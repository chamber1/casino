jQuery(document).ready(function() {
    jQuery('#vmapworld').vectorMap({
        map: 'world_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#045707', '#84F088'],
        normalizeFunction: 'polynomial'
    });
    jQuery('#vmaprussia').vectorMap({
        map: 'russia_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#094980', '#ACD2F2'],
        normalizeFunction: 'polynomial'
    });
    jQuery('#vmapgermany').vectorMap({
        map: 'germany_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#d84a38', '#F5B4AB'],
        normalizeFunction: 'polynomial'
    });
    jQuery('#vmapeurope').vectorMap({
        map: 'europe_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#ffb848', '#F5D5A4'],
        normalizeFunction: 'polynomial'
    });
    jQuery('#vmapusa').vectorMap({
        map: 'usa_en',
        backgroundColor: '#ffffff',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#5bc0de', '#D6DBDE'],
        normalizeFunction: 'polynomial'
    });
});
$('#slim1').slimscroll({
    height: '500px',
    size: '3px',
    color: '#D84A38',
    opacity: 1
});
