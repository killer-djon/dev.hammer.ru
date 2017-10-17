Ext.define('HM.model.catalogs.CatalogFilesModel', {
    extend: 'Ext.data.TreeModel',
    fields: [
        {name: 'id', mapping: '_id.$id'},
        {name: 'name', type: 'string'},
        {name: 'size', type: 'string', convert: this.convertSizeValue},
        {name: 'type', type: 'string'},
        {name: 'createdAt', type: 'date'}
    ],
    convertOnSet: false,
    convertSizeValue: function (v, record) {
        return (record.get('size') / (1024 * 2)) + 'Мб';
    }
});