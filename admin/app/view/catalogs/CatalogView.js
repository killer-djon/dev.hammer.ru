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
							{
								text: 'Скачать файл',
								glyph: 0xf019,
								bind: {
									disabled: '{!catalogFilesList.selection.leaf}'
								},
								action: 'downloadSelectedFile'
							},
							'-',
							{
								text: 'Обновить список',
								glyph: 0xf021,
								action: 'refreshFilesList'
							},
							'-',
							{
								text: 'Удалить выбранные',
								glyph: 0xf00d,
								action: 'removeSelected'
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
					flex: 1,
					dataIndex: 'filename',
					text: 'Название файла'
				},
				{
					xtype: 'templatecolumn',
					text: 'Дата загрузки',
					dataIndex: 'dateupload',
					tpl: Ext.create('Ext.XTemplate', '{dateupload:this.dateUpload}',{
						dateUpload: function(v)
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
			reference: 'catalogViewPanel',
		}
	]
});