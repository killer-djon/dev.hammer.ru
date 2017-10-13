Ext.define('HM.view.catalogs.CatalogViewController', {
	extend: 'HM.view.details.DetailsController',
	
	alias: 'controller.catalogview',
	
	privates: {

		/**
		 * Обновляем список загруженных файлов кроссов
		 * */
        refreshFilesList: function()
		{
			var refs = this.getRefs();
			refs['catalogFilesList'].getStore().load();
		},

        /**
         * Загружаем файл кроссов
         * */
		uploadFileCatalog: function()
		{
			this.showToast('Загрузить файл(ы)', [
				{
					xtype: 'panel',
					layout: 'fit',
					width: 250,
					items: [
						{
							xtype: 'xuploadpanel',
							url: 'http://hammer:nyFFqv2015@dev.hammerschmidt.ru/api/v1/json/crosses/upload',
                            menageFiles: true,
                            closerButton: true,
                            multipart_params: {
								headers: {
                                    'request': 'token'
								}
							},
                            filters: [
                                {title : "XLS Файлы", extensions : "xls,xlsx,XLS,XLSX"},
                                {title : "CSV Файлы", extensions : "csv,CSV"}
							],
                            listeners: {

                                Init: function () {
									console.log(arguments)
                                },
                                beforestart: function(uploadpanel) {
                                    console.log(uploadpanel);
                                },
                                uploadstarted: function(uploadpanel) {
                                	console.log(uploadpanel);
                                },
                                uploadcomplete: function(uploadpanel, success, failures) {
                                	console.log(uploadpanel, success)
                                }
                            }
						}
					]
				}
			]);
			
		}
	}
});