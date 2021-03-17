var config = {
    map: {
        '*': {
            aislendAlertCheck: 'Aislend_Alert/js/check',
            aislendAlert: 'Aislend_Alert/js/stock'
        }
    },
	shim:{
        aislendAlert:{
            'deps':['jquery']
        }
    }
};
