$(function($) {
    $("#example_1").ionRangeSlider({
        min: 0,
        max: 5000,
        type: 'double',
        prefix: "$",
        maxPostfix: "+",
        prettify: false,
        hasGrid: true
    });
    $("#example_2").ionRangeSlider({
        min: 1000,
        max: 100000,
        from: 30000,
        to: 90000,
        type: 'double',
        step: 500,
        postfix: " &euro;",
        hasGrid: true
    });
    $("#example_3").ionRangeSlider({
        min: 0,
        max: 10,
        type: 'single',
        step: 0.1,
        postfix: " carats",
        prettify: false,
        hasGrid: true
    });
    $("#example_4").ionRangeSlider({
        min: -50,
        max: 50,
        from: 0,
        type: 'single',
        step: 1,
        postfix: "Â°",
        prettify: false,
        hasGrid: true
    });
    $("#example_5").ionRangeSlider({
        values: [
            "January", "February", "March",
            "April", "May", "June",
            "July", "August", "September",
            "October", "November", "December"
        ],
        type: 'single',
        hasGrid: true
    });
    $("#example_6").ionRangeSlider({
        min: 10000,
        max: 100000,
        step: 100,
        type: 'double',
        postfix: " light years",
        from: 55000,
        to: 75000,
        hideMinMax: false,
        hideFromTo: true
    });
    $("#example_7").ionRangeSlider({
        min: 10000,
        max: 100000,
        step: 100,
        postfix: " light years",
        from: 55000,
        hideMinMax: true,
        hideFromTo: false
    });
});
$(document).ready(function() {
    /* Example 1 */
    $('#ex1').bootstrapSlider({
        formater: function(value) {
            return 'Current value: ' + value;
        }
    });

    /* Example 2 */
    $("#ex2").bootstrapSlider({});

    /* Example 3 */

    var RGBChange = function() {
        $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
    };

    var r = $('#R').bootstrapSlider()
        .on('slide', RGBChange)
        .data('bootstrapSlider');
    var g = $('#G').bootstrapSlider()
        .on('slide', RGBChange)
        .data('bootstrapSlider');
    var b = $('#B').bootstrapSlider()
        .on('slide', RGBChange)
        .data('bootstrapSlider');

    /* Example 4 */
    $("#ex4").bootstrapSlider({
        reversed: true
    });

    /* Example 5 */
    $("#ex5").bootstrapSlider();
    $("#destroyEx5Slider").click(function() {
        $("#ex5").bootstrapSlider('destroy');
    });

    /* Example 6 */
    $("#ex6").bootstrapSlider();
    $("#ex6").on('slide', function(slideEvt) {
        $("#ex6SliderVal").text(slideEvt.value);
    });

    /* Example 7 */
    $("#ex7").bootstrapSlider();
    $("#ex7-enabled").click(function() {
        if (this.checked) {
            $("#ex7").bootstrapSlider("enable");
            $("#enable_text").text('Disable');
            $("#slider_enabled").text('Enabled Slider');
        } else {
            $("#ex7").bootstrapSlider("disable");
            $("#enable_text").text('Enable');
            $("#slider_enabled").text('Disabled Slider');
        }
    });

    /* Example 8 */
    $("#ex8").bootstrapSlider({
        tooltip: 'always'
    });

    /* Example 9 */
    $("#ex9").bootstrapSlider({
        step: 0.01,
        value: 8.115
    });
});

/*material slider */

function setColor(){

    // Get the slider values,
    // stick them together.
    var color = 'rgb(' +
        sliders[0].noUiSlider.get() + ',' +
        sliders[1].noUiSlider.get() + ',' +
        sliders[2].noUiSlider.get() + ')';

    // Fill the color box.
    resultElement.style.background = color;
    resultElement.style.color = color;
}
var resultElement = document.getElementById('result'),
    sliders = document.getElementsByClassName('sliders');

for ( var i = 0; i < sliders.length; i++ ) {

    noUiSlider.create(sliders[i], {
        start: 127,
        connect: "lower",
        orientation: "vertical",
        range: {
            'min': 0,
            'max': 255
        },
        format: wNumb({
            decimals: 0
        })
    });

    // Bind the color changing function
    // to the slide event.
    sliders[i].noUiSlider.on('slide', setColor);
}


var connectSlider = document.getElementById('connect');

noUiSlider.create(connectSlider, {
    start: [20, 80],
    connect: false,
    range: {
        'min': 0,
        'max': 100
    }
});
var connectBar = document.createElement('div'),
    connectBase = connectSlider.querySelector('.noUi-base');

// Give the bar a class for styling and add it to the slider.
connectBar.className += 'connect';
connectBase.appendChild(connectBar);

connectSlider.noUiSlider.on('update', function( values, handle, a, b, handlePositions ) {

    var offset = handlePositions[handle];

    // Right offset is 100% - left offset
    if ( handle === 1 ) {
        offset = 100 - offset;
    }

    // Pick left for the first handle, right for the second.
    connectBar.style[handle ? 'right' : 'left'] = offset + '%';
});


var select = document.getElementById('input-select');

// Append the option elements
for ( var i = -20; i <= 40; i++ ){

    var option = document.createElement("option");
    option.text = i;
    option.value = i;

    select.appendChild(option);
}

var html5Slider = document.getElementById('html5');

noUiSlider.create(html5Slider, {
    start: [ 10, 30 ],
    connect: true,
    range: {
        'min': -20,
        'max': 40
    }
});

var inputNumber = document.getElementById('input-number');

html5Slider.noUiSlider.on('update', function( values, handle ) {

    var value = values[handle];

    if ( handle ) {
        inputNumber.value = value;
    } else {
        select.value = Math.round(value);
    }
});

select.addEventListener('change', function(){
    html5Slider.noUiSlider.set([this.value, null]);
});

inputNumber.addEventListener('change', function(){
    html5Slider.noUiSlider.set([null, this.value]);
});


var nonLinearSlider = document.getElementById('nonlinear');

noUiSlider.create(nonLinearSlider, {
    connect: true,
    behaviour: 'tap',
    start: [ 500, 4000 ],
    range: {
        // Starting at 500, step the value by 500,
        // until 4000 is reached. From there, step by 1000.
        'min': [ 0 ],
        '10%': [ 500, 500 ],
        '50%': [ 4000, 1000 ],
        'max': [ 10000 ]
    }
});

// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
    return handle.parentElement.style.left;
}

var lowerValue = document.getElementById('lower-value'),
    lowerOffset = document.getElementById('lower-offset'),
    upperValue = document.getElementById('upper-value'),
    upperOffset = document.getElementById('upper-offset'),
    handles = nonLinearSlider.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
nonLinearSlider.noUiSlider.on('update', function ( values, handle ) {
    if ( !handle ) {
        lowerValue.innerHTML = values[handle] + ', ' + leftValue(handles[handle]);
    } else {
        upperValue.innerHTML = values[handle] + ', ' + leftValue(handles[handle]);
    }
});

var weekdays = [
        "Sunday", "Monday", "Tuesday",
        "Wednesday", "Thursday", "Friday",
        "Saturday"
    ],
    months = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

// Append a suffix to dates.
// Example: 23 => 23rd, 1 => 1st.
function nth (d) {
    if(d>3 && d<21) return 'th';
    switch (d % 10) {
        case 1:  return "st";
        case 2:  return "nd";
        case 3:  return "rd";
        default: return "th";
    }
}

// Create a string representation of the date.
function formatDate ( date ) {
    return weekdays[date.getDay()] + ", " +
        date.getDate() + nth(date.getDate()) + " " +
        months[date.getMonth()] + " " +
        date.getFullYear();
}
function timestamp(str){
    return new Date(str).getTime();
}
var dateSlider = document.getElementById('slider-date');

noUiSlider.create(dateSlider, {
// Create two timestamps to define a range.
    range: {
        min: timestamp('2010'),
        max: timestamp('2016')
    },

// Steps of one week
    step: 7 * 24 * 60 * 60 * 1000,

// Two more timestamps indicate the handle starting positions.
    start: [ timestamp('2011'), timestamp('2015') ],

// No decimals
    format: wNumb({
        decimals: 0
    })
});

var dateValues = [
    document.getElementById('event-start'),
    document.getElementById('event-end')
];

dateSlider.noUiSlider.on('update', function( values, handle ) {
    dateValues[handle].innerHTML = formatDate(new Date(+values[handle]));
});
