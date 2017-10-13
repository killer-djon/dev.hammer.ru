Ext.define("HM.lib.ReferenceManager", {
	
	alternateClassName: 'HM.ReferenceManager',
	
	singleton: true,
	
	/**
     * @property {Ext.util.HashMap} refList
     * @private
     */
	refList: Ext.create('Ext.util.HashMap'),
	
	/**
     * @method register
     * Registers one or more Reference
     * @param {reference} Reference of the container. If the container has attr reference
     */
    register: function (references) {
        var me = this;

        if (Ext.isObject(references)) references = [references];

        Ext.each(references, function (reference) {
            if( !Ext.isEmpty( reference ) ) me.refList.add( reference );
        });
    },
    
    
    /**
     * @method set
     * Set single item (key, value) to the refList
     * @param {key} - Key of item
     * @param {value} - value of item
     */     
    set: function(key, value){
		var __self = this;
		
		if( Ext.isString(key) && !Ext.isEmpty(key) )
		{
			this.refList = Ext.Object.merge(this.refList, {key: value});
		}
    },
    
    
    /**
     * @method contains
     * Checks if a websocket is already registered or not
     * @param {Ext.ux.WebSocket} websocket The WebSocket to find
     * @return {Boolean} True if the websocket is already registered, False otherwise
     */
    contains: function (reference) {
        return this.refList.containsKey( Ext.Object.getKey(reference) );
    },
    
    
    /**
     * @method get
     * Retrieves a registered websocket by its url
     * @param {String} url The url of the websocket to search
     * @return {Ext.ux.WebSocket} The websocket or undefined
     */
    get: function (key) {
        return this.refList.get(key);
    },
    
    
    /**
     * @method each
     * Executes a function for each registered websocket
     * @param {Function} fn The function to execute
     */
    each: function (fn) {
        this.refList.each(function (key, reference, len) {
            fn(reference, key);
        });
    },
    
    
    /**
     * @method unregister
     * Unregisters one or more Ext.ux.WebSocket
     * @param {Ext.ux.WebSocket/Ext.ux.WebSocket[]} websockets WebSockets to unregister
     */
    unregister: function (references) {
        var me = this;

        if (Ext.isObject(references)) references = [references];
        Ext.each(references, function (reference) {
	        
            if (me.refList.containsKey( Ext.Object.getKey(references) )) me.refList.removeAtKey(Ext.Object.getKey(references));
        });
    },
    
    
    /**
     * @method closeAll
     * Closes any registered references
     */
    closeAll: function () {
        var me = this;

        me.refList.each(function (key, reference, len) {
            me.unregister(reference);
        });
    },
    
    /**
     * @method getValues
     * Return all of the values in the hash.
     */
    getValues: function(){
	    var me = this;
	    var values = this.refList.getValues();
	    
	    return ( Ext.isArray(values) ? values[0] : values );
    }
});