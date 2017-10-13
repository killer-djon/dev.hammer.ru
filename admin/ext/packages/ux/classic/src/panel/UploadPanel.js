Ext.define('Ext.ux.panel.UploadPanel', {	

	extend: 'Ext.grid.Panel',
	xtype: 'xuploadpanel',
	requires: [
		'Ext.grid.Panel'
	],
	url: '', 
	chunk_size: '512kb', 
	max_file_size: '1024mb', 
	unique_names: true, 
	multipart: true,
	multipart_params: null,
	pluploadPath: '/resources/packages/plupload/', 
	pluploadRuntimes: 'html5,gears,browserplus,silverlight,flash,html4',
	
	btnUploadClsPrefix: "x-btn-icon-gray x-btn-icon-",	

	filters: [],
	
	menageFiles: false,
	closerButton: false,
	
	texts:
	{	status: ['QUEUED', 'UPLOADING', 'UNKNOWN', 'FAILED', 'DONE'],
		statusRus: ['в ожидании', 'загружаем', 'неизвестно', 'ошибка', 'загружен'],
		DragDropAvailable: 'Переместите файлы прямо в это место...',
		noDragDropAvailable: 'Ваш браузер не поддерживает перемещение файлов...',
		emptyTextTpl: '<div style="color:#808080; margin:0 auto; text-align:center; top:48%; position:relative;">{0}</div>',
		cols: ["Название файла", "Размер", "Статус", "Сообщение"],
		addButtonText: 'Выбор файлов',
		uploadButtonText: 'Загрузить',
		cancelButtonText: 'Отмена',
		deleteButtonText: 'Удалить',
		deleteUploadedText: 'Удаление завершено',
		deleteAllText: 'Удалить все',
		deleteSelectedText: 'Удалить выделенные',
		progressCurrentFile: 'Текущий файл:',
		progressTotal: 'Всего:',
		statusInvalidSizeText: 'Файл слишком большой',
		statusInvalidExtensionText: 'Неверный формат файла',
		manageTextFiles: "Управление файлами",
		manageTextProfiles: "Управление профилями"
	},

	multiSelect: true,
	viewConfig:
	{	
		deferEmptyText: false, // For showing emptyText
	},
	columnLines: true,

	loadedFile: 0,
	forceFit: true,
	
	constructor: function(config){
	
		var me = this;
		config = Ext.apply({}, config);
		config.columns = [
			{ header: this.texts.cols[0], flex: 1, dataIndex: 'name' },
		 	{ header: this.texts.cols[1], flex: 1, align: 'right', dataIndex: 'size', renderer: Ext.util.Format.fileSize },
		 	{ header: this.texts.cols[2], flex: 1, dataIndex: 'status', renderer: this.renderStatus },
		 	{ header: this.texts.cols[3], flex: 1, dataIndex: 'msg' }
		];
		
		config.store = this._createStore();
		
		this.progressBarSingle = new Ext.ProgressBar(
		{	flex: 1,
			animate: true
		});		
		
		this.progressBarAll = new Ext.ProgressBar(
		{	flex: 2,
			animate: true
		});
		
		var topBar = this.topbar || this._getTopBar();
		var bottomBar = this.bottombar || this._getBottomBar();
		
		config.dockedItems = [
			{
				xtype: 'toolbar',
				dock: 'top',
				enableOverflow: true,
				items: ( Ext.isArray(topBar) ? topBar : [topBar] )
			},
			{
				xtype: 'toolbar',
				dock: 'bottom',
				//layout: 'hbox',
				items: ( Ext.isArray(bottomBar) ? bottomBar : [bottomBar] )
			}
		];

		
		this.callParent(arguments);
	},
	
	initComponent: function(){
		var me = this;
		
		this.callParent(arguments);
	},
	
	privates: {
		
		_createStore: function(){
			var me = this;
			var model = this.model = new Ext.data.Model({
				fields: [ 'id', 'loaded', 'name', 'size', 'percent', 'status', 'msg' ]
			});
			
			var store = this.store = new Ext.data.Store({
				model: model,
				proxy: {
					type: 'memory',
					reader: {
						type: 'json'
					}
				},
				listeners: {
					load: this.onStoreLoad,
					remove: this.onStoreRemove,
					update: this.onStoreUpdate,
					scope: me
				}
			});
			
			return store;
		},
		
		_getTopBar: function(){
			var bar = [
				{
					xtype: 'button',
					text: this.texts.addButtonText,
                    iconCls: this.btnUploadClsPrefix + 'publish',
                    itemId: 'addButton',
                    disabled: true,
                    glyph: 0xf016
				},
				{
					xtype: 'button',
					text: this.texts.uploadButtonText,
                    handler: this.onStart,
                    scope: this,
                    disabled: true,
                    itemId: 'upload',
                    glyph: 0xf0ee
				},
				{
					xtype: 'button',
					text: this.texts.cancelButtonText,
                    handler: this.onCancel,
                    scope: this,
                    disabled: true,
                    itemId: 'cancel',
                    glyph: 0xf112
				},
				'->',
				{
					xtype: 'splitbutton',
					text: this.texts.deleteButtonText,
                    //handler: this.onDeleteSelected,
                    glyph: 0xf1f8,
                    plain: true,
                    scope: this,
                    disabled: true,
                    itemId: 'delete',
                    menu: {
	                    items: [
		                    {
			                    text: this.texts.deleteAllText, 
			                    handler: this.onDeleteAll, 
			                    scope: this 
			                },
                            '-',
                            {
	                            text: this.texts.deleteSelectedText, 
	                            handler: this.onDeleteSelected, 
	                            scope: this 
	                        }	                            	                            
	                    ]
                    }
				}
				/*
                
                
                new Ext.toolbar.Fill(),
                new Ext.button.Split({
                    text: this.texts.deleteButtonText,
                    handler: this.onDeleteSelected,
                    glyph: 0xf1f8,
                    plain: true,
                    menu: new Ext.menu.Menu({
                        items: [
                            {text: this.texts.deleteAllText, handler: this.onDeleteAll, scope: this },
                            '-',
                            {text: this.texts.deleteSelectedText, handler: this.onDeleteSelected, scope: this }	                            	                            
                        ]
                    }),
                    scope: this,
                    disabled: true,
                    itemId: 'delete',
                })*/
			];
			
			return bar;
		},
		
		_getBottomBar: function(){
			
		
			var bar = [
				this.texts.progressCurrentFile,
           	 	this.progressBarSingle,
           	 	{	xtype: 'tbtext',
             		itemId: 'single',
             		style: 'text-align:right',
             		text: '',
             		//width:100
           	 	},
           	 	this.texts.progressTotal,
           	 	this.progressBarAll,
           	 	{	xtype: 'tbtext',
           	 		itemId: 'all',
             		style: 'text-align:right',
             		text: '',
             		//width:100
           	 	},	               	 	
           	 	{	xtype: 'tbtext',
           	 		itemId: 'speed',
             		style: 'text-align:right',
             		text: '',
             		//width:100
           	 	},
           	 	{	xtype: 'tbtext',
           	 		itemId: 'remaining',
             		style: 'text-align:right',
             		text: '00:00:00',
             		//width:100
           	 	}
			];
			
			return bar;
			
		}
	},
	
	initComponent: function(config){
	    var me = this;

        me.callParent(arguments);
    },
	
	setConfig: function(config){
		
		console.log( config );
	},
	
	startInit: function()
	{
		this.initPlUpload();
	},
	
	afterRender: function() 
	{	
		this.callParent(arguments);
		this.startInit();
	},
	
	renderStatus: function(value, meta, record, rowIndex, colIndex, store, view)
	{	
		var s = this.texts.statusRus[value-1];
		if (value == 2)
		{	s += " " + record.get("percent")+" %";
		}
		return s;
	},
	
	
	renderProgress: function(value, meta, record, rowIndex, colIndex, store, view)
	{	

		var id;
		if (this.progressBars[rowIndex] === undefined)
		{	console.log("Create Bar");
			id = Ext.id();
			this.progressBars[rowIndex] = id;
			Ext.Function.defer(function(id, record)
			{	console.log("Create bar ", id, value, record);
				var bar = new Ext.ProgressBar(
				{	height: 15,
					renderTo: id,
					value: (value / 100)
				});
				this.progressBars[record.id] = bar;
				console.log("After create bar", id, value, record);
			},
			25,
			this,
			[id, record]);			
		}
		else
		{	if (Ext.isObject(this.progressBars[rowIndex]))
			{	var bar = this.progressBars[rowIndex];
				bar.setValue(value);
				id = bar.getEl().dom.id;
				console.log("Fetch bar ", id);
			}
		else
			console.log("Wait for creation");
		}
		return (Ext.String.format('<div id="{0}"></div>', id));
	},
	
	
	getTopToolbar: function()
	{	
		var bars = this.getDockedItems('toolbar[dock="top"]');
		return bars[0];
	},
	getBottomToolbar: function()
	{	
		var bars = this.getDockedItems('toolbar[dock="bottom"]');
		return bars[0];	
	},
    
    initPlUpload: function () 
    {	
    	var me = this;
    	
    	if( Ext.isEmpty(this.getUrl()) ){
    		
    		Ext.Error.raise("You must type url of upload files!");
    	}
    	
    	this.uploader = new plupload.Uploader(
    	{	url: me.getUrl(),
    		runtimes: this.pluploadRuntimes,
    		browse_button: this.getTopToolbar().getComponent('addButton').getEl().dom.id,
    		container: this.getEl().dom.id,
    		max_file_size: this.max_file_size || '',
    		resize: this.resize || '',
    		flash_swf_url: this.pluploadPath+'plupload.flash.swf',
    		silverlight_xap_url: this.pluploadPath+'plupload.silverlight.xap',
    		filters : this.filters || [],
    		chunk_size: this.chunk_size,
    		unique_names: this.unique_names,
    		multipart: this.multipart,
    		multipart_params: this.multipart_params || null,
    		drop_element: this.getEl().dom.id,
    		required_features: this.required_features || null
    	});
    	
    	// Events
    	Ext.each(['Init', 'ChunkUploaded', 'FilesAdded', 'FilesRemoved', 'FileUploaded', 'PostInit',
		          'QueueChanged', 'Refresh', 'StateChanged', 'UploadFile', 'UploadProgress', 'Error' ], 
		          function(v){
		          
			          var _funcname = me['Plupload'+v];
					  this.uploader.bind(v, _funcname, this); 
		          }, this);

    	this.uploader.init();
    	this.fireEvent('Init', this, this.uploader);
    },
    
    setUrl: function(url){
	    this.url = url;
    },
    
    getUrl: function(){
	    return this.url;
    },
    
    setMultipartParams: function(params)
    {
		this.multipart_params = params || {};		  	  
    },
    
    getMultipartParams: function(){
	    return this.multipart_params;
    },
    
    onDeleteSelected: function () 
    {	Ext.each(this.getView().getSelectionModel().getSelection(), 
            function (record) {
                this.remove_file( record.get( 'id' ) );
            }, this
        );
    },
    onDeleteAll: function () 
    {	
    	this.store.data.each(function(record){
	        this.remove_file(record.get( 'id' ));
        }, this);
        
    },
    onDeleteUploaded: function () 
    {
        this.store.each(
            function (record) {
                if ( record.get( 'status' ) == 5 ) {
                    this.remove_file( record.get( 'id' ) );
                }
            }, this
        );
    },
    onCancel: function () 
    {	
    	this.uploader.stop();
    	this.updateProgress();
    	
    },

    onStart: function () 
    {	
    	this.fireEvent('beforestart', this);
        if (this.multipart_params)
        {	this.uploader.settings.multipart_params = this.multipart_params;
        }
        this.uploader.start();
    },
    
    
    
    remove_file: function (id)
    {	var fileObj = this.uploader.getFile(id);
        if (fileObj)
        {	this.uploader.removeFile(fileObj);
        }
        else 
        {	this.store.remove(this.store.getById(id));
        }
        
        this.onCancel();
    },
    updateStore: function(files)
    { 	Ext.each(files, function(data) 
		{	this.updateStoreFile(data);
		}, this);	
    },
	updateStoreFile: function (data) 
	{	data.msg = data.msg || '';
		var record = this.store.getById(data.id);
		if (record) 
		{	record.set(data);
			record.commit();
		}
		else 
		{	this.store.add(data);
		}
		
	},
    onStoreLoad: function (store, record, operation)
    {    	
    },
    onStoreRemove: function (store, record, operation)
    {	
    	if (!store.data.length) 
    	{	this.getTopToolbar().getComponent('delete').setDisabled(true);
    		this.getTopToolbar().getComponent('upload').setDisabled(true);
        	this.uploader.total.reset();
    	}
    	
    	
    	var id = record[0].get('id');

	    Ext.each( this.success, 
	        function (v) {
	            if ( v && v.id == id ) {
	                Ext.Array.remove(this.success, v);
	            }
	        }, this
	    );

	    Ext.each( this.failed, 
	        function (v) {
	            if ( v && v.id == id ) {
	            	Ext.Array.remove(this.failed, v);
	            }
	        }, this
	    );
	    
    },
    onStoreUpdate: function (store, record, operation)
    {	var canUpload = false;
    	if (this.uploader.state != 2)
    	{	this.store.each(function (record) 
    			{	if (record.get("status") == 1) 
    				{	canUpload = true;
    					return false;                
    				}
    			}, this);
    	}
    	this.getTopToolbar().getComponent('upload').setDisabled(!canUpload);
    },
    
    updateProgress: function(file)
    {	
    
    	var queueProgress = this.uploader.total;    	
    	
    	// All
    	var total = queueProgress.size;
    	var uploaded = queueProgress.loaded;
    	this.getBottomToolbar().getComponent('all').setText(Ext.util.Format.fileSize(uploaded)+"/"+Ext.util.Format.fileSize(total));
    	
    	if (total > 0)
    			this.progressBarAll.updateProgress(queueProgress.percent/100, queueProgress.percent+" %");
    	else	this.progressBarAll.updateProgress(0, ' ');
    	
    	// Speed+Remaining
    	var speed = queueProgress.bytesPerSec;
    	if (speed > 0)
    	{	var totalSec = parseInt((total-uploaded)/speed);
    		var hours = parseInt( totalSec / 3600 ) % 24;
    		var minutes = parseInt( totalSec / 60 ) % 60;
    		var seconds = totalSec % 60;
    		var timeRemaining = result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);     		
    		this.getBottomToolbar().getComponent('speed').setText(Ext.util.Format.fileSize(speed)+'/s');
    		this.getBottomToolbar().getComponent('remaining').setText(timeRemaining);
    	}
    	else
    	{	this.getBottomToolbar().getComponent('speed').setText('');
    		this.getBottomToolbar().getComponent('remaining').setText('00:00:00');
    	}

    	// Single
    	if (!file)
    	{	this.getBottomToolbar().getComponent('single').setText('');
    		this.progressBarSingle.updateProgress(0, ' ');
    	}
    	else
    	{	total = file.size;
    		//uploaded = file.loaded; // file.loaded sometimes is 1 step ahead, so we can not use it.
    		//uploaded = 0; if (file.percent > 0) uploaded = file.size * file.percent / 100.0; // But this solution is imprecise as well since percent is only a hint
    		uploaded = this.loadedFile; // So we use this Hack to store the value which is one step back
    		this.getBottomToolbar().getComponent('single').setText(Ext.util.Format.fileSize(uploaded)+"/"+Ext.util.Format.fileSize(total));
    		this.progressBarSingle.updateProgress(file.percent/100, (file.percent).toFixed(0)+" %");
    	}    	
    },
    
    PluploadInit: function(uploader, data) 
    {	this.getTopToolbar().getComponent('addButton').setDisabled(false);
    	// console.log("Runtime: ", data.runtime);
    	if (data.runtime == "flash" || 
    		data.runtime == "silverlight" ||
    		data.runtime == "html4")
    	{	this.view.emptyText = this.texts.noDragDropAvailable;
    	}
    	else
    	{	this.view.emptyText = this.texts.DragDropAvailable    		
    	}
    	this.view.emptyText = Ext.String.format(this.texts.emptyTextTpl, this.view.emptyText);
    	this.view.refresh();
    	
    	this.updateProgress();
    },
    PluploadChunkUploaded: function() 
    {	
    },
    PluploadFilesAdded: function(uploader, files) 
    {
	    this.getTopToolbar().getComponent('delete').setDisabled(false);
		this.updateStore(files);
		this.updateProgress();
		
		this.fireEvent('FilesAdded', this, uploader, files);
    },
	PluploadFilesRemoved: function(uploader, files) 
	{	
		Ext.each(files, 
            function (file) {
        		this.store.remove( this.store.getById( file.id ) );
    		}, this
		);
		
		this.updateProgress();
	},
	PluploadFileUploaded: function(uploader, file, status) 
	{	
		var me = this;
		var response = Ext.JSON.decode( status.response );
		if ( response.success == true )
		{	file.server_error = 0;
			this.fireEvent('onUpload', uploader, file, status);
			me.fireEvent('FileUploaded', me, uploader, file, status);
			
			this.success.push(file);
			if( response.message ){
				file.msg = '<span style="color: green">' + response.message + '</span>';
			}
		}
		else 
		{	if ( response.message ) 
			{	file.msg = '<span style="color: red">' + response.message + '</span>';
			}
			file.server_error = 1;
			this.failed.push(file);
		}
		this.updateStoreFile(file);
		this.updateProgress(file);
		
	},
	PluploadPostInit: function() 
	{		
	},
	PluploadQueueChanged: function(uploader) 
	{	this.updateProgress();
	},
	PluploadRefresh: function(uploader) 
	{	this.updateStore(uploader.files);
		this.updateProgress();
	},
	PluploadStateChanged: function(uploader) 
	{	if (uploader.state == 2) 
		{	this.fireEvent('uploadstarted', this);
			this.getTopToolbar().getComponent('cancel').setDisabled(false);			
		} 
		else 
		{	this.fireEvent('uploadcomplete', this, this.success, this.failed);
		 	this.getTopToolbar().getComponent('cancel').setDisabled(true);
		}		
	},
	PluploadUploadFile: function() 
	{	this.loadedFile = 0;
	},
	PluploadUploadProgress: function(uploader, file)
	{	// No chance to stop here - we get no response-text from the server. So just continue if something fails here. Will be fixed in next update, says plupload.
		if ( file.server_error ) 
		{	file.status = 4;
		}		
		this.updateStoreFile(file);
		this.updateProgress(file);
		this.loadedFile = file.loaded;
	},
	PluploadError: function (uploader, data) 
	{	data.file.status = 4;
		if ( data.code == -600 ) 
		{	data.file.msg = Ext.String.format( '<span style="color: red">{0}</span>', this.texts.statusInvalidSizeText );
		}
		else if ( data.code == -700 || data.code == -601 ) 
		{	data.file.msg = Ext.String.format( '<span style="color: red">{0}</span>', this.texts.statusInvalidExtensionText );
		}
		else 
		{	data.file.msg = Ext.String.format( '<span style="color: red">{2} ({0}: {1})</span>', data.code, data.details, data.message );
		}
		this.updateStoreFile(data.file);
		this.updateProgress();
	}
	
});