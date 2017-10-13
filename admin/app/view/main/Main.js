/**
 * This class is the main view for the application. It is specified in app.js as the
 * "mainView" property. That setting automatically applies the "viewport"
 * plugin causing this view to become the body element (i.e., the viewport).
 *
 * TODO - Replace this content of this view to suite the needs of your application.
 */
Ext.define('HM.view.main.Main', {
    extend: 'Ext.tab.Panel',
    xtype: 'app-main',

    requires: [
        'HM.view.main.MainController',
        'HM.view.main.MainModel',
    ],

    controller: 'main',
    viewModel: {
	    type: 'main'
    },

    ui: 'navigation',

    tabBarHeaderPosition: 1,
    titleRotation: 0,
    tabRotation: 0,
	removePanelHeader: false,
    header: {
        layout: {
            align: 'stretchmax'
        },
        title: {
            bind: {
                text: '{name}'
            },
            flex: 0
        },
        iconCls: 'fa-th-list'
    },

    tabBar: {
        flex: 1,
        layout: {
            align: 'stretch',
            overflowHandler: 'none'
        }
    },

    responsiveConfig: {
        tall: {
            headerPosition: 'top'
        },
        wide: {
            headerPosition: 'left'
        }
    },

    defaults: {
        bodyPadding: 5,
        tabConfig: {
            plugins: 'responsive',
            responsiveConfig: {
                wide: {
                    iconAlign: 'left',
                    textAlign: 'left'
                },
                tall: {
                    iconAlign: 'top',
                    textAlign: 'center',
                    width: 120
                }
            }
        }
    },
	
	listeners: {
		tabchange: 'onMainViewTabChange'    
    },
    reference: 'mainTabPanel',
    items: [
	    {
		    xtype: 'component',
	        tabConfig: {
	            hidden: true
	        },
	    },
	    {
		    title: 'Автозапчасти',
		    glyph: 0xf1b9,
		    reference: 'detailsViewContainer',
		    xtype: 'detailsview'
	    },
	    {
		    title: 'Каталоги/Кроссы',
		    xtype: 'catalogview',
		    glyph: 0xf187
	    },
	    {
		    title: 'Пользователи',
		    glyph: 0xf0c0,
		    xtype: 'usersview',
		    reference: 'usersViewContainer',
	    },	    
	    {
		    title: 'Новостная лента',
		    glyph: 0xf1ea,
	    },	    
	    {
		    title: 'Корзина заказов',
		    glyph: 0xf291
	    },
	    {
		    xtype: 'reportsview',
		    title: 'Отчеты',
		    glyph: 0xf201
	    },
	    {
		    title: 'Настройки',
		    glyph: 0xf085
	    }
    ]
});
