Ext.define('HM.store.catalogs.CatalogCrossHammerStore', {
    extend: 'Ext.data.Store',
    model: 'HM.model.catalogs.CatalogCrossHammerModel',
    autoLoad: false,
    autoSync: true,
    alias: 'store.catalogs.CatalogCrossHammerStore',
    proxy: {
        type: 'rest',
        url: '/api/v1/json/crosshammer',
        api: {
            destroy: '/api/v1/json/crosshammer/delete',
            update: '/api/v1/json/crosshammer/update'
        },
        reader: {
            type: 'json',
            rootProperty: 'items',
            totalProperty: 'total'
        }
    },
    pageSize: 25,
    remoteSort: true,
    listeners: {
        /**
         * Перед тем как загрузить данные
         * */
        beforeload: function (store, operation) {
            var treePanel = Ext.getCmp('crossfilestree'),
                selection = treePanel.getSelectionModel().getSelection()[0];


            store.getProxy().setExtraParam('file_id', selection.get('id'));
        },

        /**
         * КОгда мы обновляем запись
         * */
        update: function ( store, record, operation, modifiedFieldNames, details, eOpts ) {
            var treePanel = Ext.getCmp('crossfilestree');
            store.getProxy().setExtraParam('id', record.get('id'));
        }
}
});