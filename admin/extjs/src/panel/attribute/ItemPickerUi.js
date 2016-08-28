/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


Ext.ns('MShop.panel.attribute');

MShop.panel.attribute.ItemPickerUi = Ext.extend(MShop.panel.AbstractListItemPickerUi, {

    title : MShop.I18n.dt('admin', 'Attribute'),

    initComponent : function() {

        Ext.apply(this.itemConfig, {
            title : MShop.I18n.dt('admin', 'Associated attributes'),
            xtype : 'MShop.panel.listitemlistui',
            domain : 'attribute',
            getAdditionalColumns : this.getAdditionalColumns.createDelegate(this)
        });

        Ext.apply(this.listConfig, {
            title : MShop.I18n.dt('admin', 'Available attributes'),
            xtype : 'MShop.panel.attribute.listuismall'
        });

        MShop.panel.attribute.ItemPickerUi.superclass.initComponent.call(this);
    },

    getAdditionalColumns : function() {
        return [
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'typename',
                header : MShop.I18n.dt('admin', 'List type'),
                id : 'listtype',
                width : 70
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('admin', 'Status'),
                id : 'refstatus',
                width : 50,
                align : 'center',
                renderer : this.refStatusColumnRenderer.createDelegate(this, ['attribute.status'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('admin', 'Type'),
                id : 'reftype',
                width : 70,
                renderer : this.refColumnRenderer.createDelegate(this, ['attribute.typename'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('admin', 'Code'),
                id : 'refcode',
                width : 80,
                renderer : this.refColumnRenderer.createDelegate(this, ['attribute.code'], true)
            },
            {
                xtype : 'gridcolumn',
                dataIndex : conf.listNamePrefix + 'refid',
                header : MShop.I18n.dt('admin', 'Label'),
                id : 'refcontent',
                renderer : this.refColumnRenderer.createDelegate(this, ['attribute.label'], true)
            }];
    }
});

Ext.reg('MShop.panel.attribute.itempickerui', MShop.panel.attribute.ItemPickerUi);
