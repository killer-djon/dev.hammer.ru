Ext.define('HM.model.users.UsersModel', {
	extend: 'Ext.data.TreeModel',
	
	fields: [{
        name: 'task',
        type: 'string'
    }, {
        name: 'user',
        type: 'string'
    }, {
        name: 'duration',
        type: 'date',
        dateFormat: 'd.m.Y'
    }, {
        name: 'done',
        type: 'boolean'
    }]
});