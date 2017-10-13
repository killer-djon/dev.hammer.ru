Ext.define('HM.store.users.UsersStore', {
	extend: 'Ext.data.TreeStore',
	requires: [
		'HM.model.users.UsersModel'
	],
	autoLoad: false,
	autoSync: false,
	
	model: 'HM.model.users.UsersModel',
	proxy: {
		type: 'ajax',
		url: 'resources/data/users.json',
		reader: {
			type: 'json',
			//rootProperty: 'items'
		}
	},
});