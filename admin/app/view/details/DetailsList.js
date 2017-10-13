Ext.define('HM.view.details.DetailsList', {
	extend: 'Ext.grid.Panel',
	
	xtype: 'detailslist',
	forceFit: true,
	columnLines: true,
	rowLines: true,
	viewConfig: {
		stripeRows: true,
		trackOver: false,
	},
	disableSelection: true,
    loadMask: true,
    store: 'details.DetailsListStore',
	columns: [
		{
			xtype: 'rownumberer',
			text: '№',
			width: 30
		},
		{
			text: 'Наименование',
			flex: 1,
			dataIndex: 'name',
		},
		{
			text: 'Код детали',
			flex: 1,
			dataIndex: 'article',
		},
		{
			text: 'Производитель',
			flex: 1,
			dataIndex: 'manufacture',
		},
		{
			text: 'Кол-во',
			dataIndex: 'count'
		},
		{
			xtype: 'templatecolumn',
			text: 'Цена',
			tpl: Ext.create('Ext.XTemplate', '{[ this.formatPrice(values.price) ]}', {
				formatPrice: function(v)
				{
					if( v !== '' )
					{
						return v+' руб.';
					}

					return v;
				}
			}),
			dataIndex: 'price'
		}
	],
	bbar: {
		xtype: 'pagingtoolbar',
		store: 'details.DetailsListStore',
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display",
	}
});