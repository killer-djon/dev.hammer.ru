Ext.define('HM.store.catalogs.CatalogCrossHammerStore', {
    extend: 'Ext.data.Store',
    model: 'HM.model.catalogs.CatalogCrossHammerModel',
    autoLoad: false,
    autoSync: true,
    proxy: {
        type: 'rest',
        url: '/api/v1/json/crosshammer',
        api: {
            destroy: '/api/v1/json/crosshammer/delete',
            update: '/api/v1/json/crosshammer/update'
        },
        reader: {
            type: 'json',
            rootProperty: 'items'
        }
    },
    listeners: {
        beforeload: function (store, operation) {
            var treePanel = Ext.getCmp('crossfilestree'),
                selection = treePanel.getSelectionModel().getSelection()[0];


            store.getProxy().setExtraParam('file_id', selection.get('id'));
        }
    }
});