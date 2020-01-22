jQuery(document).ready(function(){
    $("#register_country").fancyfields({ 
	customScrollBar:true 
    });
    $('#role_account').fancyfields();
    
    $('#register_birthday select').each(function(){
        $(this).fancyfields({
                customScrollBar:true,
                onSelectChange: function(){ajaxFormSave();}
            }
        )
    });
    // form validation
    formVerify('registerFrm');
    formAjaxSaving();
    formFilesFill();
//    addBirthdayPlaceholders();
});

function formVerify(formClass){
    // function for check support html5 form validation in current browser
    function hasFormValidation() {
        return (typeof document.createElement( 'input' ).checkValidity === 'function');
    }
    var form = $('form.'+formClass);
    if(!form.length){
        console.error('form <form.'+formClass+'> is not found');
        return false;
    }
    
    var requiredFileds = [];
    form.find('input').each(function(){
        if($(this).attr('required') === 'required'){
            requiredFileds.push($(this));
        }
    });
    form.find('select').each(function(){
        if($(this).attr('required') === 'required'){
            requiredFileds.push($(this));
        }
    });
    
    // concat 
    var publicName = form.find('.public-name');
    var firstName = form.find('.first-name');
    var lastName = form.find('.last-name');
    firstName.bind('blur',function(){
        publicName.val(firstName.val() + ' ' + lastName.val());
    });
    lastName.bind('blur',function(){
        publicName.val(firstName.val() + ' ' + lastName.val());
    });

    // checked function
    // return true if all fields are valid or false if are not
    function checkFields(fields){
        
        var messageShow = false;
        var errorClass = 'error';
        var cssError = {'border':'1px solid #f00'};
        var cssValid = {'border':'none'};
        var error = []; // arr for non valid
        var errorMessage = []; // arr for non valid message
        $.each(fields,function(i){
            var _this = fields[i];
            // remove error class
            $('label[for='+_this.attr('id')+']').removeClass(errorClass).css(cssValid);
            _this.removeClass(errorClass).css(cssValid);
            form.find('.error-message').remove();
            // get value
            var _value = _this.val();
            if(_value.length === 0){
                error.push(_this);
                errorMessage.push('Please fill this field.');
            }
            // attr min and max
            var min = _this.attr('min');
            var max = _this.attr('max');
            // check functions
            if(typeof(min) !== 'undefined' && _value.length < min){
                error.push(_this);
                errorMessage.push('Min length of value is '+min);
            }
            if(typeof(max) !== 'undefined' && _value.length > max){
                error.push(_this);
                errorMessage.push('Max length of value is '+max);
            }
            if(_this.prop('type') === 'email'){
                var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(_value.match(pattern) === null){
                    error.push(_this);
                    errorMessage.push('Email is not valid.');
                }
            }
            if(_this.prop('type') === 'checkbox' && _this.prop('checked') === false 
                || _this.prop('type') === 'radio' && _this.prop('checked') === false){
               error.push(_this);
               errorMessage.push('Field is not checked.');
            }
            // match
            var rel = _this.attr('rel');
            if(typeof(rel) !== 'undefined'){
                var validRel = true;
                form.find('input[rel='+rel+']').each(function(){
                    if(this.value !== _value) {
                        validRel = false;
                    }
                });
                if(validRel === false){
                   error.push(_this); 
                   errorMessage.push('Fields are must match.');
                }
            }
        });
        
        // add class on the non valid fields
        $.each(error,function(i){
            if(messageShow){
                var span = $('<span>').addClass('error-message').text(errorMessage[i]);
                span.insertAfter($(this));
            }
            $(this).addClass(errorClass).css(cssError);
            $('label[for='+$(this).attr('id')+']').addClass(errorClass).css(cssError);
        });
        if(error.length === 0){
            return true;
        }
        return false;
    }
    // submit 
    form.find('[type=submit]').each(function(){
        $(this).unbind().bind('click',function(e){
            return checkFields(requiredFileds);
        });
    });
}
//
//function addBirthdayPlaceholders(){
//    if ($('#register_birthday div.ffSelect a.span:nth-child(1)').text() == '')
//        $('#register_birthday div.ffSelect a.span:nth-child(1)').text('<i class="" style="float: left;">DD</i>');
//    if ($('#register_birthday div.ffSelect:nth-child(3) span').text() == '')
//        $('#register_birthday div.ffSelect:nth-child(3) span').text('MM');
//    if ($('#register_birthday div.ffSelect:nth-child(5) span').text() == '')
//        $('#register_birthday div.ffSelect:nth-child(5) span').text('YYYY');
//}

function formAjaxSaving(){
    $('form#id_verify_form :input').on('change', function (){
        ajaxFormSave();
    });
}
function ajaxFormSave(){
    form = $('form#id_verify_form');
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serializeArray(),
        success: function(data, status, xhr) {
            console.log(status);
        },
        error: function(xhr, status, err) {
            console.log('ajax error by submit form');
        }
    });
}

function formFilesFill(){
    $("form.registerFrm").on('submit', function(){ 
        if ($('#register_file_id').attr('s3_url') != undefined){

            $('#register_file_id_json').val('{"name":"'+$('#register_file_id').attr('filename')
                            +'","s3_url":"'+$('#register_file_id').attr('s3_url')
                            +'"}');
        }
        
        if ($('#register_file_bank_statement').attr('s3_url') != undefined){

            $('#register_file_bank_statement_json').val('{"name":"'+$('#register_file_bank_statement').attr('filename')
                            +'","s3_url":"'+$('#register_file_bank_statement').attr('s3_url')
                            +'"}');
        }
        
        if ($('#register_file_scan_utility_statement').attr('s3_url') != undefined){

            $('#register_file_scan_utility_statement_json').val('{"name":"'+$('#register_file_scan_utility_statement').attr('filename')
                            +'","s3_url":"'+$('#register_file_scan_utility_statement').attr('s3_url')
                            +'"}');
        }
        //return false;
    });
}