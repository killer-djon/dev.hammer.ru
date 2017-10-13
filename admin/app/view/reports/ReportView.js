Ext.define('HM.view.reports.ReportView', {
	extend: 'Ext.panel.Panel',
	xtype: 'reportsview',
	
	requires: [
		'HM.view.reports.ReportViewController',
		'HM.view.reports.ReportViewModel',
		'Ext.ux.layout.ResponsiveColumn'
	],
	controller: 'reportsview',
	viewModel: {
		type: 'reportsview'
	},
	
	layout: 'responsivecolumn',

    
    items: [
	    {
            xtype: 'panel',
            title: 'Пользователи',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
        {
            xtype: 'panel',
            title: 'Страницы',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
        {
            xtype: 'panel',
            title: 'Посещения',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
        {
            xtype: 'panel',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
        {
            xtype: 'panel',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
        {
            xtype: 'panel',
            responsiveCls: 'big-50 small-100',
            height: 380,
        },
    ]
});