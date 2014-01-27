jq = jQuery.noConflict();

function addError(selector, msg) {
    var id = jq(selector).attr('id');
    if (isError(selector)) {
        if (jq(selector).hasClass('inline-error')) {
            jq(selector).next('.ns_error').html(msg);
            return;
        }

        jq('#error_' + id).html('<p>' + msg + '</p><span class="ns_arrow"></span><span class="ns_icon"></span>');
        return;
    }
    jq(selector).addClass('ns_error');

    jq('label[for="' + id + '"]').addClass('ns_error');
    if (jq(selector).hasClass('inline-error')) {
        jq('<span class="ns_error ns_left">' + msg + '</span>').insertAfter(selector);
        return;
    }
    jq('#ns_sidebar').append('<div id="error_' + id + '" class="ns_bubble ns_error" ><p>' + msg + '</p><span class="ns_arrow"></span><span class="ns_icon"></span></div>');

    // fetch the absolute position of the screen / browser window
    var offset = jq(selector).offset();
    var y = parseInt(offset.top, 10);
    offset = jq('#error_' + id).offset();
    var x = parseInt(offset.left, 10);
    // set the absolute position of the screen / browser window
    jq('#error_' + id).offset({top: y - 4, left: x});
    jq('#error_' + id).hide();
    jq('#error_' + id).fadeIn('slow');
    hideTooltip();
}

/**
 * Add error with the absolute position refer to a nominated html element, suitable for all browsers.
 * @param selector html selector
 * @param direction {'top', 'right', 'left', bottom'}
 * @param msg error message
 * @param posref_selector a selector of which the position should be referred to, default is @param selector if not provided
 * @param additional
 * @return bool
 */
function addAbPosError(selector, direction, msg, posref_selector, additional) {
    if (isError(selector)) {
        return true;
    }
    if (!(direction == 'top' || direction == 'bottom' || direction == 'left' || direction == 'right')) {
        return false;
    }

    jq(selector).addClass('ns_error');
    var ref = posref_selector ? posref_selector : selector;
    var ref_pos = { left: parseInt(jq(ref).offset().left, 10),
            top: parseInt(jq(ref).offset().top, 10),
            width: parseInt(jq(ref).css('width'), 10),
            height: parseInt(jq(ref).css('height'), 10) };
    var err = jq('<span></span>').addClass('ns_error').css('position', 'absolute').css('z-index', '1010').attr('selector', selector).html(msg);
    if (additional && additional.width) {
        err.css('width', additional.width);
    }
    err.insertAfter(ref);
    switch (direction) {
        case 'right':
            err.offset({top: ref_pos.top + (additional ? additional.top : 0), left: ref_pos.left + ref_pos.width + (additional ? additional.left : 0)}).show();
            break;
        case 'bottom':
            err.offset({top: ref_pos.top + ref_pos.height + (additional ? additional.top : 0), left: ref_pos.left + (additional ? additional.left : 0)}).show();
            break;
    }
}

function removeAbPosError(selector) {
    if (isError(selector)) {
        jq(selector).removeClass('ns_error');
        jq('.ns_error[selector=' + selector + ']').remove();
    }
}

/**
 * This function only add error message to the same line of the given element
 * If you want to apply error to the element use: addError()
 * @param selector
 * @param id
 * @param msg
 */
function addErrorMsg(selector, id, msg) {
    if (jq('#error_' + id).length !== 0) {
        jq('#error_' + id).html('<p>' + msg + '</p><span class="ns_arrow"></span><span class="ns_icon"></span>');
        return;
    }
    jq('#ns_sidebar').append('<div id="error_' + id + '" class="ns_bubble ns_error" ><p>' + msg + '</p><span class="ns_arrow"></span><span class="ns_icon"></span></div>');

    // fetch the absolute position of the screen / browser window
    var offset = jq(selector).offset();
    var y = parseInt(offset.top, 10);
    offset = jq('#error_' + id).offset();
    var x = parseInt(offset.left, 10);
    // set the absolute position of the screen / browser window
    jq('#error_' + id).offset({top: y - 4, left: x});
    jq('#error_' + id).hide();
    jq('#error_' + id).fadeIn('slow');
}

function removeError(selector, hideTips) {
    if (isError(selector)) {
        var id = jq(selector).attr('id');
        if (jq(selector).hasClass('inline-error')) {
            jq(selector).next('.ns_error').remove();
        }

        jq('#error_' + id).fadeOut('slow', function() {
            jq('#error_' + id).remove();
        });
        jq('#' + id).removeClass('ns_error');
        jq('label[for="' + id + '"]').removeClass('ns_error');
    if (hideTips === null)
            showTooltip();
    }
}
function removeErrorMessage(selector, hideTips) {
    if (isError(selector)) {
        var id = jq(selector).attr('id');
        if (jq(selector).hasClass('inline-error')) {
            jq(selector).next('.ns_error').remove();
        }

        //jq('#error_' + id).fadeOut('slow', function() {
            jq('#error_' + id).remove();
        //});
        jq('#' + id).removeClass('ns_error');
        jq('label[for="' + id + '"]').removeClass('ns_error');
    if (hideTips === null)
            showTooltip();
    }
}

/**
 * This will only remove the error message bubble
 * If you want to remove error from the element use: removeError()
 * @param id int id of the error message
 */
function removeErrorMsg(id) {
    jq('#error_' + id).fadeOut('slow', function() {
        jq('#error_' + id).remove();
    });
}

function removeAllErrors() {
    jq('.ns_bubble.ns_error').remove();
    jq('.ns_error').each(function() {
        jq(this).removeClass('ns_error');
    });
}

function isError(selector) {
    return (jq(selector).hasClass('ns_error'));
}

function syncErrorPosition(selector) {
    var id = jq(selector).attr('id');
    // fetch the absolute position of the screen / browser window
    var offset = jq(selector).offset();
    var y = parseInt(offset.top, 10);
    offset = jq('#error_' + id).offset();
    var x = parseInt(offset.left, 10);
    // set the absolute position of the screen / browser window
    jq('#error_' + id).offset({top: y - 4, left: x});
}

function switchWizard(selector, total_state, index) {
    for (var i = 1; i <= total_state; ++i) {
        jq(selector).removeClass('ns_wizard-' + total_state + '-state-' + i);
    }
    jq(selector).addClass('ns_wizard-' + total_state + '-state-' + index);
    for (i = 1; i <= total_state; ++i) {
        jq('ul li:nth-child(' + i + ') a').removeClass('ns_wizard-selected');
    }
    jq('ul li:nth-child(' + index + ') a').addClass('ns_wizard-selected');
}

function updateCheck(selector) {
    if (jq(selector).is(':checked')) {
        addCheck(selector);
    }
    else {
        removeCheck(selector);
    }
}

function addCheck(selector) {
    jq(selector).parents('li').addClass('ns_selected');
}

function removeCheck(selector) {
    jq(selector).parents('li').removeClass('ns_selected');
}

function displayTooltip(selector, msg) {
    jq('#form_tooltip').fadeOut('fast', function() {
        // fetch the absolute position of the screen / browser window
        var offset = jq(selector).offset();
        var y = parseInt(offset.top, 10);
        // in order to get position correctly tooltip must be rendered
        jq('#form_tooltip').show();
        offset = jq('#form_tooltip').offset();
        var x = parseInt(offset.left, 10);
        // set the absolute position of the screen / browser window
        jq('#form_tooltip').offset({top: y - 4, left: x});
        jq('#form_tooltip').hide();
        jq('#form_tooltip > p').html(msg);
        if (isError(selector)) {
            hideTooltip();
        } else {
            showTooltip();
        }
    });
}

function hideTooltip() {
    jq('#form_tooltip').fadeOut('fast');
}

function showTooltip() {
    jq('#form_tooltip').fadeIn('slow');
}

function syncTooltipPosition(selector) {
    // fetch the absolute position of the screen / browser window
    var offset = jq(selector).offset();
    var y = parseInt(offset.top, 10);
    offset = jq('#form_tooltip').offset();
    var x = parseInt(offset.left, 10);
    // set the absolute position of the screen / browser window
    jq('#form_tooltip').offset({top: y - 4, left: x});
}

function checkCharacterLimit(inputBox, counterSpan, limit, truncate) {
    var str = jq(inputBox).val();
    var count = str.length;
    if (count > limit) {
        if (truncate) {
            count = limit;
            jq(inputBox).val(str.substr(0, limit));
        }
    }
    jq(counterSpan).html(limit - count);
    if (count > limit) {
        return false;
    }
    return true;
}

jq(document).on('click', 'ul.ns_checkbox-big > li', function(event) {
    if ((event.target.type !== 'checkbox') && (event.target.type !== 'radio') && (event.target.tagName !== 'LABEL')) {
        jq('input', this).trigger('click');
        jq('input', this).trigger('change');
    }
});

jq(document).on('click', 'ul.ns_radio-btn > li', function(event) {
    if ((event.target.type !== 'checkbox') && (event.target.type !== 'radio') && (event.target.tagName !== 'LABEL')) {
        jq('input', this).trigger('click');
        jq('input', this).trigger('change');
    }
});

jq(document).on('change', '.ns_radio-btn input[type=radio]', function(event) {
    jq('.ns_radio-btn input[name=' + jq(this).attr('name') + ']').parents('li').removeClass('ns_selected');
    jq(this).parents('li').addClass('ns_selected');
});

jq(document).ready(function() {
    jq('.ns_radio-btn input[type=radio]:checked').parents('li').addClass('ns_selected');
});
