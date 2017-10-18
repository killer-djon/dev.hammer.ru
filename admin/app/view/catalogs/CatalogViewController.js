Ext.define('HM.view.catalogs.CatalogViewController', {
    extend: 'HM.view.details.DetailsController',

    alias: 'controller.catalogview',

    privates: {

        onSelectCrossFile: function (panel, record, item, index, e){
            var refs = HM.lib.ReferenceManager.getValues();

            if( refs['catalogViewPanel'] )
            {
                refs['catalogViewPanel'].getStore().load({
                    params: {
                        file_id: record.get('id')
                    }
                });
            }
        },

        onToolbarPagingClick: function () {
            console.log(arguments)
        },

        onRemoveCrossDetail: function (grid, colIndex, rowIndex, item, e, record, row) {
            var refs = HM.lib.ReferenceManager.getValues();
            if( refs['catalogViewPanel'] )
            {
                refs['catalogViewPanel'].getStore().remove(record);
            }
        },

        /**
         * Обновляем список загруженных файлов кроссов
         * */
        refreshFilesList: function () {
            var refs = this.getRefs();
            refs['catalogFilesList'].getStore().load();
        },

        /**
         * Очищаем список файлов
         * */
        clearFilesList: function () {
            var refs = this.getRefs();
            refs['catalogFilesList'].getStore().getRoot().removeAll();
        },

        /**
         * Удаляем выбранные файлы
         * */
        removeSelected: function () {
            var refs = this.getRefs();
            var store = refs['catalogFilesList'].getStore();
            var selections = refs['catalogFilesList'].getSelectionModel();

            var refs = this.getRefs(),
                tree = refs['catalogFilesList'],
                selection = tree.getSelectionModel().getSelection(),
                i, len;

            if (selection.length > 0) {
                for (i = 0, len = selection.length; i < len; i++) {
                    selection[i].remove();
                }
            }
        },

        /**
         * Анализируем файл на наличие кроссов
         * */
        analyzeFile: function (btn) {
            var refs = this.getRefs(),
                tree = refs['catalogFilesList'],
                store = tree.getStore();

            Ext.Ajax.request({
                url: '/api/v1/json/crosses/fileStructure',
                method: 'POST',
                params: {
                    file_id: tree.getSelectionModel().getSelection()[0].data.id
                },
                scope: this,
                success: function (response, opts) {
                },
                callback: this.analyzeResponseFile,

                failure: function (response, opts) {
                    console.log('server-side failure with status code ' + response.error);
                }
            });
        },

        analyzeResponseFile: function (self, success, response) {
            var obj = Ext.decode(response.responseText);
            if (success) {
                var headers = [];
                Ext.Array.each(obj.headers, function (header, index) {
                    var field = {
                        xtype: 'container',
                        columnWidth: 1,
                        layout: 'column',
                        bodyPadding: 5,

                        defaults: {
                            bodyPadding: 15,
                            margin: '0 0 10 0'
                        },
                        items: [
                            {
                                xtype: 'textfield',
                                editable: false,
                                value: header,
                                name: 'field_' + index,
                                columnWidth: 0.45,
                                labelAlign: 'top',
                                hideLabel: true
                            },
                            {
                                xtype: 'combobox',
                                columnWidth: 0.5,
                                name: 'combo_' + index,
                                margin: '0 0 0 5',
                                labelAlign: 'top',
                                hideLabel: true,
                                queryMode: 'local',
                                displayField: 'name',
                                valueField: 'value',
                                store: Ext.create('Ext.data.Store', {
                                    fields: ['value', 'name'],
                                    data: [
                                        {"value": "article", "name": "Артикул"},
                                        {"value": "name", "name": "Наименование"},
                                        {"value": "manufacture", "name": "Производитель"},
                                        {"value": "cross_article", "name": "Артикул кроссирования"},
                                        {"value": "qty", "name": "Кол-во на складе"},
                                        {"value": "price", "name": "Цена за единицу"}
                                    ]
                                })
                            }
                        ]
                    };
                    headers.push(field);
                });

                if (headers.length > 0) {
                    this.showToast('Анализтор списка', [
                        {
                            xtype: 'form',
                            width: 250,
                            items: headers,
                            scrollable: 'y',
                            layout: 'anchor',
                            anchor: '100%',
                            items: [
                                {
                                    xtype: 'hiddenfield',
                                    name: 'filename',
                                    value: obj.filename
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Выбор полей соответствия',
                                    items: headers
                                }
                            ],
                            dockedItems: [{
                                xtype: 'toolbar',
                                dock: 'bottom',
                                layout: {
                                    pack: 'center'
                                },
                                items: [
                                    {xtype: 'button', text: 'Сохранить', handler: this.saveCrosses}
                                ]
                            }]
                        }
                    ]);
                }
            }
        },

        /**
         * Сохраняем значение полей
         * для кроссов
         * */
        saveCrosses: function (btn, btnEvent) {
            var win = btn.up('window'),
                form = win.down('form').getForm(),
                fieldValues = form.getFieldValues();

            var regex = /^combo/g;
            var comboFields = function () {
                var field = [];

                Ext.Object.each(fieldValues, function (key, value) {
                    if (regex.test(key)) {
                        if (value) {
                            var fieldIndex = (form.findField(key).name).replace(/^combo_/g, '');
                            field.push({
                                'id': fieldIndex,
                                'value' : value
                            });
                        }
                    }
                });

                return field;
            };

            Ext.Ajax.request({
                url: '/api/v1/json/crosses/fileAnalyzeData',
                method: 'POST',
                loadMask: true,
                params: {
                    file_rows: Ext.encode(comboFields()),
                    filename: form.findField('filename').getValue()
                },
                scope: this,
                success: function (response, opts) {
                    win.close();
                },
                failure: function (response, opts) {
                    console.log('server-side failure with status code ' + response.error);
                }
            });
        },

        /**
         * Загружаем файл кроссов
         * */
        uploadFileCatalog: function () {
            var refs = this.getRefs();
            this.showToast('Загрузить файл(ы)', [
                {
                    xtype: 'panel',
                    layout: 'fit',
                    width: 250,
                    items: [
                        {
                            xtype: 'xuploadpanel',
                            url: '/api/v1/json/crosses/upload',
                            menageFiles: true,
                            closerButton: true,
                            filters: [
                                {title: "XLS Файлы", extensions: "xls,xlsx,XLS,XLSX"},
                                {title: "CSV Файлы", extensions: "csv,CSV"}
                            ],
                            listeners: {
                                onUpload: function (plupload, file) {
                                    console.log(arguments)
                                }
                            }
                        }
                    ]
                }
            ], function () {
                refs['catalogFilesList'].getStore().load();
            });

        }
    }
});