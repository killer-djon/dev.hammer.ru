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
			tbar: [
				{
					xtype: 'splitbutton',
					glyph: 0xf03a,
					menu: {
						listeners: {
							click: 'onToolbarUsersListClick',
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
			xtype: 'panel',
			title: 'Загруженные детали',
			region: 'center',
			reference: 'catalogViewPanel'
		}
	]
});