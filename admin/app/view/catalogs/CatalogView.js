Ext.define('HM.view.catalogs.CatalogView', {
	extend: 'Ext.panel.Panel',
	xtype: 'catalogview',
	
	requires: [
		'HM.view.catalogs.CatalogViewController',
		'HM.view.catalogs.CatalogViewModel'
	],
	controller: 'catalogview',
	viewModel: {
		type: 'catalogview'
	},
	
	layout: 'border',
	reference: 'catalogView',
	items: [
		{
			xtype: 'treepanel',
			title: 'Список файлов',
			store: 'catalogs.CatalogFilesStore',
			region: 'west',
			width: '35%',
			split: true,
			collapsible: true,
			forceFit: true,
			columnLines: true,
			rowLines: true,
			viewConfig: {
				stripeRows: true
			},
			useArrows: true,
			rootVisible: false,
			reference: 'catalogFilesList',
			selModel: {
				mode: 'MULTI'
			},
			listeners: {
                itemclick: 'onSelectCrossFile'
			},
			id: 'crossfilestree',
			tbar: [
				{
					xtype: 'splitbutton',
					glyph: 0xf03a,
					menu: {
						listeners: {
							click: 'onToolbarUsersListClick'
						},
						items: [
							{
								text: 'Загрузить файл(ы)',
								glyph: 0xf093,
								action: 'uploadFileCatalog'
							},
							'-',
							{
								text: 'Обновить список',
								glyph: 0xf021,
								action: 'refreshFilesList'
							},
                            {
                                text: 'Анализировать',
                                glyph: 0xf0ec,
                                action: 'analyzeFile',
								bind: {
                                    disabled: '{!catalogFilesList.selection}'
								}
                            },
							'-',
							{
								text: 'Удалить выбранные',
								glyph: 0xf00d,
								action: 'removeSelected',
                                bind: {
                                    disabled: '{!catalogFilesList.selection}'
                                }
							},
							{
								text: 'Очистить список',
								glyph: 0xf12d,
								action: 'clearFilesList'
							}
						]
					}
				}
			],
			columns: [
				{
					xtype: 'treecolumn',
					flex: 2,
					dataIndex: 'name',
					text: 'Название файла'
				},
				{
					xtype: 'templatecolumn',
					text: 'Дата загрузки',
					flex: 1,
					dataIndex: 'createdAt',
					tpl: Ext.create('Ext.XTemplate', '{createdAt:this.createdAt}',{
                        createdAt: function(v)
						{
							return v;
						}
					})
				}
			]
		},
		{
			xtype: 'gridpanel',
			title: 'Загруженные детали кроссов',
			region: 'center',
			reference: 'catalogViewPanel',
			store: 'catalogs.CatalogCrossHammerStore',

            columns: [
                { text: 'Артикул детали', dataIndex: 'article' },
                { text: 'Кроссированный артикул', dataIndex: 'cross_article', flex: 1 },
                { text: 'Наименование', dataIndex: 'name' },
                { text: 'Производитель', dataIndex: 'manufacture' },
                { text: 'Кол-во на складе', dataIndex: 'qty',
                    editor: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
						allowDecimals: false
                    }
				},
                { text: 'Цена за шт.', dataIndex: 'price',
                    editor: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0
                	}
                },
                {
                    xtype: 'actioncolumn',
                    width: 30,
                    sortable: false,
                    menuDisabled: true,
                    items: [{
                        iconCls: 'fa fa-remove',
                        tooltip: 'Удалить деталь кросса',
                        handler: 'onRemoveCrossDetail'
                    }]
                }
            ],
            selModel: {
                type: 'cellmodel'
            },
            plugins: [{
                ptype: 'cellediting',
                clicksToEdit: 2
            }],
            forceFit: true,
            columnLines: true,
            rowLines: true,
            viewConfig: {
                stripeRows: true,
                trackOver: false,
            },
            disableSelection: true,
            loadMask: true,
            bbar: {
                xtype: 'pagingtoolbar',
                store: 'catalogs.CatalogCrossHammerStore',
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display"
            }
		}
	]
});