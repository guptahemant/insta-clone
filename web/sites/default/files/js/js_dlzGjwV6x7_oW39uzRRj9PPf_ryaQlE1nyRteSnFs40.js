jQuery('h1, h2').each(function(i) {
  jQuery(this).rainbow({
    originalText: jQuery(this).text(),
    colors: [
        '#FF0000',
        '#f26522',
        '#fff200',
        '#00a651',
        '#28abe2',
        '#2e3192',
        '#6868ff',
    ],
    animate: true, 
    animateInternal: 100,
    pad: false,
    pauseLength: 100,
  });
});;
;
