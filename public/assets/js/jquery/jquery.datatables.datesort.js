jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-euro-pre": function ( a ) {
        
        var frDatea = $.trim(a).split(' ');
        var frTimea = frDatea[1].split(':');
        var frDatea2 = frDatea[0].split('/');
        
        
        dateObj = new Date(frDatea2[2],frDatea2[1],frDatea2[0],frTimea[0],frTimea[1]);
        
        x = dateObj.getTime();
        
        
        return x;
    },
 
    "date-euro-asc": function ( a, b ) {
        //return a - b;
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "date-euro-desc": function ( a, b ) {
        //return b - a;
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );



jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        var ukDatea = a.split('/');
        dateObj = new Date(ukDatea[2],ukDatea[1],ukDatea[0]);
        x = dateObj.getTime();
        return x;
    },
 
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );