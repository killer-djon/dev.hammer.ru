Ext.define('HM.view.users.UsersList', {
	extend: 'Ext.tree.Panel',
	xtype: 'userslist',
	title: 'Список пользователей',
	forceFit: true,
	columnLines: true,
	rowLines: true,
	
	viewConfig: {
		stripeRows: true
	},

	rootVisible: false,
	useArrows: true,
	reference: 'userListItems',
	
	store: 'users.UsersStore',
	tbar: [
		{
			xtype: 'splitbutton',
			glyph: 0xf0c9,
			text: 'Дейтсвия',
			menu: {
				listeners: {
					click: 'onToolbarUsersListClick'
				},
				items: [
					{
						text: 'Добавить пользователя',
						glyph: 0xf0fe,
					},
					{
						text: 'Удалить пользователя',
						glyph: 0xf146
					},
					'-',
					{
						text: 'Обновить список',
						glyph: 0xf021,
						action: 'refreshItems'
					}
				]
			}
		}
	],
	columns: [
		{
			xtype: 'treecolumn',
			dataIndex: 'task',
			text: 'Имя пользователя',
			flex: 2
		},
		{
			xtype: 'templatecolumn',
			dataIndex: 'duration',
			text: 'Зарегистрирован',
			flex: 1,
			tpl: Ext.create('Ext.XTemplate', '{duration:this.displayDate}', {
				displayDate: function(v)
				{
					return Ext.util.Format.date(v, 'd.m.Y');
				}
			})
		}
	]
});