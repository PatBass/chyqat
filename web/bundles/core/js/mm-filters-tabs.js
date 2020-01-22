jQuery(document).ready(function(){
    /* sort on button click */
    $("#sortNewest").click(function() {
       sortUsingNestedText($('.listResults'), "li", "span.joined_date", false, false);
    });
    $("#sortOldest").click(function() {
       sortUsingNestedText($('.listResults'), "li", "span.joined_date", true, false);
    });
    $("#sortName").click(function() {
       sortUsingNestedText($('.listResults'), "li", "h4.pfName", true, false);
    });
    $("#sortlstInvest").click(function() {
       sortUsingNestedText($('.listResults'), "li", "span.investments", false, true);
    });

    $('.sortBy li').click(function(){
       if($('.sortBy li').hasClass('active'))
       {
           $('.sortBy li').removeClass('active');
       }
       $(this).addClass('active');
    });
        
    $('#tabs').tabs();
    initFilters();
});

function applyFilter(element) {
    var xmlhttp;
    xmlhttp = changeInnerHTML(xmlhttp, 'peopleList');

    var pramStr = "fltr=fltr";

    if((window.location.href).indexOf("?") == -1)
      pramStr = "?" + pramStr;
    else{
        if((window.location.href).indexOf("?")!= (window.location.href).length-1 )
           pramStr = "&" + pramStr;
    }

    if(document.getElementById("txt_search").value != '')
       pramStr = pramStr + "&fltrname=" + document.getElementById("txt_search").value  ;

    //alert(window.location.href + pramStr );
    xmlhttp.open("GET", window.location.href + pramStr ,true);
    xmlhttp.send();
 }
 
 function sortUsingNestedText(parent, childSelector, keySelector, asc, num) {
    var items = parent.children(childSelector).sort(function(a, b) {
        var vA = $(keySelector, a).text();
        var vB = $(keySelector, b).text();
        if (num){
            vA = parseInt(vA);
            vB = parseInt(vB);
        }
        if (asc)
            return (vA < vB) ? -1 : (vA > vB) ? 1 : 0;
        else
            return (vA > vB) ? -1 : (vA < vB) ? 1 : 0;
    });
    parent.append(items);
}

function addIfNotIn(array, value) {
    var index = array.indexOf(value);

    if (index === -1) {
        array.push(value);
    }
}

function ajaxFilter(filterType, val){
    $.ajax({
        type: 'post',
        url: getFilterPath,
        dataType: 'html',
        data: {"filter_type" : filterType,
               'filter_value' : val
        },
        success: function(data) {
            data = JSON.parse(data);
            $('#peopleList').html(data.html);
            return true;

        },
        error: function(data) {
            console.log(data);
            console.log('ajax error');
            return false;
        }
    });
}


function initFilters(){
    jQuery(document).ready(function(){
        $('.filterLocation button').on('click', function(){
            ajaxFilter("location", $(this).parent().find('input[type=hidden]').val());
        });
        
        $('.filterRole button').on('click', function(){
            ajaxFilter("role", $(this).parent().find('input[type=hidden]').val());
        });
        
        $('.filterAccess button').on('click', function(){
            ajaxFilter("access", $(this).parent().find('input[type=hidden]').val());
        });
    });
}

