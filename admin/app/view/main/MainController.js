/**
 * This class is the controller for the main view for the application. It is specified as
 * the "controller" of the Main view class.
 *
 * TODO - Replace this content of this view to suite the needs of your application.
 */
Ext.define('HM.view.main.MainController', {
    extend: 'Ext.app.ViewController',

    alias: 'controller.main',


	config: {
		
		/*
		 * Current refs object
		 * @var Object	
		 */
		refs: {}
	},

	/*
	 * Click on the item menu of
	 * main toolbar panel from UserList
	 *
	 * @param Ext.menu.Menu menu - Main menu panel from toolbar
	 * @param Ext.menu.Item - Menu item from this menu container
	 * @param Ext.event.Event - Clicked event on this item
	 *	
	 */
	onToolbarUsersListClick: function(menu, item, event)
	{
		var action = item.action || null;
		this.setRefs(HM.lib.ReferenceManager.getValues());
		if( action !== null && Ext.isFunction( this[action] ) )
		{
			var method = this[action];
			Ext.callback(method, this, arguments);
		}
	},
	
    /**
	* @action onMainViewTabChange
	* @access public
	*
	* This action perfect release @lambda clicked main tabpanel
	* And if we have another action on the child viewController then well be do that
	* in this case child action has name "onChildTabChange" - this is method of contain them class
	*
	* @param {Ext.tab.Panel} - Tabpanel when fired action tabchnage
	* @param {Ext.panel.Panel} - Currect panel clicked
	* @param {Ext.panel.Panel} - Old panel
	*
	* @return (void) - Fired clicked action on the tabpanel
	*/
	onMainViewTabChange: function(tabpanel, currentPanel, oldPanel){
		var currentRefs = {};
		HM.lib.ReferenceManager.closeAll();
		if( typeof currentPanel.getController == 'function' )
		{
			if( currentPanel.getReference() !== null )
			{
				currentRefs[currentPanel.getReference()] = currentPanel;	
			}
			
			var childController = currentPanel.getController();
			var refs = Ext.Object.merge(
				currentRefs || {}, 
				childController && childController.getReferences()
			);
			HM.lib.ReferenceManager.register(refs);
			
		}
	},
	
	
	/*
	 * Show toast dialog
	 * with title, and container
	 *
	 * @param string title String title on the toast window
	 *
	 * @return void Only show toast window
	 */
	showToast: function(title, _items) {
		var _items = (Ext.isObject(_items) ? [_items] : _items) || [];
		
        Ext.toast({
            closable: true,
            align: 't',
            slideInDuration: 400,
            minWidth: 600,
            title: title,
            modal: true,
            autoClose: false,
            layout: 'fit',
            height: 350,
            items: _items
        });
    },
});
