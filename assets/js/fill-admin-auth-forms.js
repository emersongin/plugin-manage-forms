
document.addEventListener('DOMContentLoaded', function() {


    postTypeData.items.forEach(element => {
        el = document.getElementById(element.key);
        el.value = element.value;

        switch (el.tagName) {
            case 'INPUT':
                
                break;
            case 'SELECT':
            
                break;
            default:
                break;
        }

    });


});
