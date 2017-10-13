Ext.define('HM.view.users.UsersController', {
	extend: 'HM.view.main.MainController',
	
	alias: 'controller.users',
	
	
	/*
	 * COntainer with privates functions
	 * for this controller	
	 */
	privates: {
		
		refreshItems: function()
		{
			var refs = this.getRefs();
			if( Ext.Object.getSize(refs) > 0 )
			{
				refs['userListItems'].getStore().load();	
			}
		}
	}
});