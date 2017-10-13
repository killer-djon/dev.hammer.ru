Ext.define('HM.view.users.UsersView', {
	extend: 'Ext.panel.Panel',
	
	xtype: 'usersview',
	
	requires: [
		'HM.view.users.UsersController',
		'HM.view.users.UsersViewModel',
		
		'HM.view.users.UsersList',
		
	],
	
	controller: 'users',
	viewModel: {
		type: 'users'
	},
	
	layout: 'border',
	items: [
		{
			xtype: 'userslist',
			region: 'west',
			split: true,
			width: '35%',
		},
		{
			xtype: 'panel',
			title: 'Редактор данных пользователя',
			region: 'center',
			reference: 'userspanel'
		}
	]
});