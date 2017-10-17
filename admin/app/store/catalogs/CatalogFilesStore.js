Ext.define('HM.store.catalogs.CatalogFilesStore', {
    extend: 'Ext.data.TreeStore',
    requires: [
        'HM.model.catalogs.CatalogFilesModel'
    ],
    autoLoad: false,
    autoSync: true,

    model: 'HM.model.catalogs.CatalogFilesModel',
    proxy: {
        type: 'rest',
        api: {
            read    : '/api/v1/json/crosses/listFiles',
            destroy: '/api/v1/json/crosses/removeFile'
        },
        reader: {
            type: 'json'
        }
    },
    defaultRootProperty: 'items',
    root: {
        expanded: true,
        name: 'Список загруженых файлов'
    }
});