Ext.define('HM.view.details.DetailsView', {
	extend: 'Ext.panel.Panel',
	xtype: 'detailsview',
	
	layout: 'border',
	requires: [
		'HM.view.details.DetailsController',
		'HM.view.details.DetailsViewModel',
		'HM.view.details.DetailsList',
		'Ext.form.Panel'
	],
	controller: 'details',
	viewModel: {
		type: 'details',
	},
	items: [
		{
			xtype: 'panel',
			region: 'center',
			header: {
				layout: {
					type: 'fit'
		        },
		        title: {
		        	hidden: true
		        },
				items: [
					{
						xtype: 'container',
						layout: {
							type: 'hbox',
							align: 'stretchmax'
						},
						defaults: {
							flex: 1,
							labelAlign: 'top',
							margin: '0 5 0 0'
						},
						items: [
							{
								xtype: 'combobox',
								fieldLabel: 'Производитель',
								displayField: 'name',
								valueField: 'id',
								queryMode: 'local',
								store: null
							},
							{
								xtype: 'combobox',
								fieldLabel: 'Модель',
								displayField: 'name',
								valueField: 'id',
								queryMode: 'local',
								store: null
							},
							{
								xtype: 'combobox',
								fieldLabel: 'Код двигателя',
								displayField: 'name',
								valueField: 'id',
								queryMode: 'local',
								store: null
							}
						]
					}
				]
			},
			layout: 'fit',
			items: [
				{
					xtype: 'detailslist',
					title: 'Наличие запчастей'
				}
			]
		},
		{
			xtype: 'panel',
			region: 'east',
			width: '25%',
			title: 'Информация'
		}
	]
});