
document.addEventListener('DOMContentLoaded', function() {
    let divItemsList = document.getElementById( itemsList.id );
    let addButton = document.getElementById( itemsList.id + '-add' );
    let divTotal = document.getElementById( itemsList.id + '-total' );
    let itemsTotalValues = document.getElementsByClassName("items-list-value");
    let itemsTotalDeletes = document.getElementsByClassName("items-list-delete");

    let item = {
        init: function() {
            this.p = this.createElement("p");
            this.inputText = this.createElement("input");
            this.inputValue = this.createElement("input");
            this.button = this.createElement("button");
            this.icon = this.createElement("span");
            this.buttonText = this.createElement("span");
            
            this.setAttributes();
            this.setClass();
            this.setStyle();

        },
        setAttributes: function() {
            this.inputText.setAttribute("type", "text");
            this.inputText.setAttribute("name", "item_service_text[]");
            this.inputText.setAttribute("placeholder", "item text");
            this.inputText.required = true;

            this.inputValue.setAttribute("type", "number");
            this.inputValue.setAttribute("step", "0.01");
            this.inputValue.setAttribute("name", "item_service_value[]");
            this.inputValue.setAttribute("placeholder", "item value");
            this.inputValue.required = true;

            this.button.setAttribute("type", "button");
            

        },
        setClass: function() {
            this.inputText.classList.add("regular-text");
            this.inputValue.classList.add("all-options", "items-list-value");
            this.button.classList.add("button-secondary", "items-list-delete");

            this.icon.classList.add("dashicons");
            this.icon.classList.add("dashicons-trash");
            
        },
        setStyle: function() {
            this.icon.style.marginTop = "3px";
            this.p.style.margin = "4px";

        },
        new: function( text = '', value = 0 ) {
            let p = this.p.cloneNode(true);
            let inputText = this.inputText.cloneNode(true);
            let inputValue = this.inputValue.cloneNode(true);
            let button = this.button.cloneNode(true);
            let icon = this.icon.cloneNode(true);
            let buttonText = this.buttonText.cloneNode(true);
            buttonText.innerHTML = " delete";

            button.appendChild(icon);
            button.appendChild(buttonText);

            button.addEventListener("click", function(event) {            
                event.preventDefault();
        
                p.remove();
                if ( itemsTotalValues.length <= 0 ) {
                    divItemsList.appendChild( item.new('', 0) );

                }

            });

            inputText.value = String(text);
            inputValue.value = Number(value);

            p.appendChild(inputText);
            p.appendChild(inputValue);
            p.appendChild(button);

            return p;

        },
        createElement: function( tag ) {
            return document.createElement(tag);

        }
    }

    item.init();

    if ( itemsList.items.length ) {
        itemsList.items.forEach(element => {
            divItemsList.appendChild( item.new( element.text, element.value ) );

        });

    } else {
        divItemsList.appendChild( item.new( '', 0 ) );

    }

    addButton.addEventListener("click", function(event) {
        event.preventDefault();

        divItemsList.appendChild( item.new('', 0) );
        updateTotal();

    });

    function updateTotal() {
        let total = 0;

        for (let index = 0; index < itemsTotalValues.length; index++) {
            let value = parseFloat(itemsTotalValues[index].value);
            
            value = isNaN(value) ? 0 : value;
            total += value;

            itemsTotalValues[index].addEventListener('change', updateTotal);
            itemsTotalDeletes[index].addEventListener('click', updateTotal);
            
        }

        divTotal.innerHTML = "Total " + total.toFixed(2);

    }

    updateTotal();

});
