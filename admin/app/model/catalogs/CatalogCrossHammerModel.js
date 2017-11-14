Ext.define('HM.model.catalogs.CatalogCrossHammerModel', {
    extend: 'Ext.data.Model',

    requires: [
        'HM.model.catalogs.CatalogFilesModel'
    ],

    idProperty: 'id',

    fields: [
        {name: 'id', mapping: '_id.$id'},
        {name: 'name', type: 'string', defaultValue: ''},
        {name: 'date_create', type: 'date'},
        {name: 'article', type: 'string'},
        {name: 'manufacture', type: 'string'},
        {name: 'cross_article', type: 'string'},
        {name: 'qty', type: 'int', defaultValue: 0},
        {name: 'price', type: 'float', defaultValue: 0.00},
        {name: 'file_id', reference: 'catalogs.CatalogFilesModel'}
    ],

    convertOnSet: false
});