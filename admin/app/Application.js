/**
 * The main application class. An instance of this class is created by app.js when it
 * calls Ext.application(). This is the ideal place to handle application launch and
 * initialization details.
 */
Ext.define('HM.Application', {
    extend: 'Ext.app.Application',
    
    name: 'HM',

	views: [
		'users.UsersView',
		'details.DetailsView',
		'reports.ReportView',
		'catalogs.CatalogView'
	],

    stores: [
        'users.UsersStore',
        'details.DetailsListStore'
    ],
    
    launch: function () {
        // TODO - Launch the application
    },

    onAppUpdate: function () {
        Ext.Msg.confirm('Application Update', 'This application has an update, reload?',
            function (choice) {
                if (choice === 'yes') {
                    window.location.reload();
                }
            }
        );
    }
});
