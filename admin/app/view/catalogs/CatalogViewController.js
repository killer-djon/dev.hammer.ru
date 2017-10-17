Ext.define('HM.view.catalogs.CatalogViewController', {
	extend: 'HM.view.details.DetailsController',
	
	alias: 'controller.catalogview',
	
	privates: {

		/**
		 * Обновляем список загруженных файлов кроссов
		 * */
        refreshFilesList: function()
		{
			var refs = this.getRefs();
			refs['catalogFilesList'].getStore().load();
		},

		/**
		 * Очищаем список файлов
		 * */
        clearFilesList: function () {
            var refs = this.getRefs();
            refs['catalogFilesList'].getStore().getRoot().removeAll();
        },

        /**
         * Удаляем выбранные файлы
         * */
        removeSelected: function () {
            var refs = this.getRefs();
            var store = refs['catalogFilesList'].getStore();
            var selections = refs['catalogFilesList'].getSelectionModel();

            var refs =  this.getRefs(),
				tree = refs['catalogFilesList'],
                selection = tree.getSelectionModel().getSelection(),
                i, len;

            if( selection.length > 0 )
			{
                for (i = 0, len = selection.length; i < len; i++) {
                    selection[i].remove();
                }
			}
        },

		/**
		 * Анализируем файл на наличие кроссов
		 * */
        analyzeFile: function (btn) {
            var refs = this.getRefs(),
				tree = refs['catalogFilesList'],
				store = tree.getStore();

            Ext.Ajax.request({
                url: '/api/v1/json/crosses/fileStructure',
				method: 'POST',
                params: {
                	file_id: tree.getSelectionModel().getSelection()[0].data.id
				},
                scope : this,
                success: function(response, opts) {},
				callback: this.analyzeResponseFile,

                failure: function(response, opts) {
                    console.log('server-side failure with status code ' + response.error);
                }
            });
        },

        analyzeResponseFile: function (self, success, response) {
            var obj = Ext.decode(response.responseText);
            if( success )
            {
                var headers = [];
                Ext.Array.each(obj.headers, function (header, index) {
                    var field = {
                        xtype: 'textfield',
                        name: index,
                        fieldLabel: header,
                        allowBlank: false,
                        editable: false
                    };
                    headers.push(field);
                });

                if( headers.length > 0 )
				{
					this.showToast('Анализтор списка', [
						{
							xtype: 'panel',
							width: 250,
							layout: 'form',
							items: headers
						}
					]);
				}
            }
        },

        /**
         * Загружаем файл кроссов
         * */
		uploadFileCatalog: function()
		{
            var refs = this.getRefs();
			this.showToast('Загрузить файл(ы)', [
				{
					xtype: 'panel',
					layout: 'fit',
					width: 250,
					items: [
						{
							xtype: 'xuploadpanel',
							url: '/api/v1/json/crosses/upload',
                            menageFiles: true,
                            closerButton: true,
                            filters: [
                                {title : "XLS Файлы", extensions : "xls,xlsx,XLS,XLSX"},
                                {title : "CSV Файлы", extensions : "csv,CSV"}
							],
                            listeners: {
                                onUpload: function (plupload, file) {
									console.log( arguments )
                                }
                            }
						}
					]
				}
			], function () {
                refs['catalogFilesList'].getStore().load();
            });
			
		}
	}
});