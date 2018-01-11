var shiftDown = false;
var controlDown = false;

function OrderedTable(name, targetElement, tableHeaders, data){

	this.name = name;
	this.targetElement = targetElement;
	this.tableHeaders = tableHeaders;
    this.data = data;

    this.firstHeader;

    this.currentHoveringRowIndex = 0;
    this.lastClickedRowIndex = -1;

    this.normalColor = "rgb(245, 248, 250)";
    this.hoverColor = "rgb(238, 238, 238)";
    this.selectedColor = "rgb(221, 221, 221)";

    this.domRows = [];
    this.domHeaders = [];
    this.selectedItems = [];

    this.events = [];

    this.orderedColumn;
    this.orderStatus = 0;

    this.init = function(){
        this.constructEventList();
        this.firstHeader = this.getFirstColumn();
    }

	this.print = function(){
		var targetElement = document.getElementById(this.targetElement);

        var table = document.createElement("table");
        table.id = this.name;
        table.className = "table";
        targetElement.append(table);

        this.generateHeader(table);
        this.generateRows(table);

        this.createRowEvents();
        this.createHeaderEvents();
	}

    this.generateHeader = function(table){

        this.domHeaders = [];
        var thead = document.createElement("thead");
        table.append(thead);
                    
        for (var key in this.tableHeaders){
            let th = document.createElement("th");
            th.innerHTML = key;
            thead.append(th);

            this.domHeaders.push(th);
        }     
    }

    this.generateRows = function(table){

        this.domRows = [];
        var tbody = document.createElement("tbody");
        tbody.className = "allDataBody";
        table.append(tbody); 

        for (var i = 0; i < this.data.length; i++){
            let tr = document.createElement("tr");
            tbody.append(tr);

            for (var key in this.tableHeaders){

                let td = document.createElement("td");
                td.innerHTML = this.data[i][tableHeaders[key]];
                tr.append(td);
            }

            this.domRows.push(tr);
        }
    }

    this.createRowEvents = function(){

        var self = this;

        for (var i in this.domRows){
            let tr = this.domRows[i];

            tr.addEventListener('mouseover', function (e) {
                this.style.backgroundColor = self.hoverColor;
                self.currentHoveringRowIndex = self.getItemIndex(this);
            });

            tr.addEventListener('mouseleave', function (e) {
                var index = self.getItemIndex(this);
                this.currentHoveringRowIndex = -1;

                if (self.isRowSelected(index)){
                    this.style.backgroundColor = self.selectedColor;
                }
                else {
                    this.style.backgroundColor = self.normalColor;
                }
            });
           
            tr.addEventListener('click', function (e) {
                var index = Number(self.getItemIndex(this));

                if (shiftDown){
                    document.getSelection().removeAllRanges();

                    var minIndex = self.lastClickedRowIndex;
                    var maxIndex = index;

                    if (minIndex > maxIndex){
                        maxIndex = [minIndex, minIndex = maxIndex][0];
                    }

                    self.clearSelection();

                    for (var i = minIndex; i < maxIndex + 1; i++){
                        self.selectRow(i);
                    }
                } else if (controlDown) {
                    if (self.isRowSelected(index)){
                        self.deselectRow(index);
                    } else {
                        self.selectRow(index);
                    }
                } else {
                    self.clearSelection();
                    self.selectRow(index);
                    self.lastClickedRowIndex = index;

                    self.triggerEvent("rowNormalClick", index);
                }

                self.updateRowSelectionStyle();

                self.triggerEvent("rowClick", index);
            });
        }
    }

    this.createHeaderEvents = function(){
        var self = this;

        var i = 0;
        for (let headerIndex in this.tableHeaders){

            let th = this.domHeaders[i];

            th.addEventListener('click', function(e){

                if (self.orderedColumn != headerIndex){
                    self.orderStatus = 1;
                } else {
                    self.orderStatus++;
                }
              
                if (self.orderStatus == 1){
                    self.orderOn(self.getHeaderValue(headerIndex), 0);
                }
                else if (self.orderStatus == 2){                  
                    self.orderOn(self.getHeaderValue(headerIndex), 1);
                } else if (self.orderStatus == 3){
                    self.orderOn(self.firstHeader, 0);
                    self.orderStatus = 0;
                }              

                self.orderedColumn = headerIndex;
            });

            i++;
        }
    }

    this.getFirstColumn = function(){
        for(var i in this.tableHeaders){
            return this.tableHeaders[i];
        }
    }

    this.constructEventList = function(){
        this.events["rowClick"] = [];
        this.events["rowNormalClick"] = [];
    }

    this.getItemIndex = function(tr){
        for (var i in this.domRows){
            var item = this.domRows[i];

            if(item === tr){
                return i;
            }
        }

        return -1;
    }

    this.selectRow = function(rowIndex){
        this.selectedItems.push(Number(rowIndex));
    }

    this.deselectRow = function(rowIndex){
        var index = this.selectedItems.indexOf(rowIndex);
        this.selectedItems.splice(Number(index), 1);
    }

    this.clearSelection = function(){
        this.selectedItems = [];
    }

    this.selectAllRows = function(){
        for (var i in this.domRows){
            this.selectRow(i);
        }
    }

    this.isRowSelected = function(rowIndex){
        for (var i in this.selectedItems){
            if (this.selectedItems[i] == rowIndex){
                return true;
            }
        }

        return false;
    }

    this.updateRowSelectionStyle = function(){
        for (var i in this.domRows){
            if (this.currentHoveringRowIndex == i){
                this.domRows[i].style.backgroundColor = this.hoverColor;
            } else if (this.isRowSelected(i)){
                this.domRows[i].style.backgroundColor = this.selectedColor;
            } else {
                this.domRows[i].style.backgroundColor = this.normalColor;
            }
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.keyCode == 16) {
            shiftDown = true;
        } else if (event.keyCode == 17){
            controlDown = true;
        }   
    });

    document.addEventListener('keyup', function(event) {
        if (event.keyCode == 16) {
            shiftDown = false;
        } else if (event.keyCode == 17){
            controlDown = false;
        }
    });

    this.refresh = function(){
        var targetElement = document.getElementById(this.targetElement);

        while (targetElement.firstChild) {
            targetElement.removeChild(targetElement.firstChild);
        }

        this.print();
    }

    /**
     * Order all the contacts by property of object with given property key.
     * isDesc boolean should be 0 for ascending, 1 for descending.
     */
    this.orderOn = function(key, isDesc){

        this.data.sort(function(a, b){

            var aKeyValue=a[key], bKeyValue=b[key];

            if (isNaN(aKeyValue)){

                if (aKeyValue instanceof Date){
                    var dateA = new Date(aKeyValue), dateB = new Date(bKeyValue);

                    if (isDesc){
                        return !dateA - dateB;
                    } else {
                        return dateA - dateB;
                    }

                } else {
                    aKeyValue = aKeyValue.toLowerCase();
                    bKeyValue = bKeyValue.toLowerCase();

                    if (aKeyValue < bKeyValue){
                        if (isDesc){
                            return 1;
                        } else {
                            return -1;
                        }
                    }

                    if (aKeyValue > bKeyValue){
                        if (isDesc){
                            return -1;
                        } else {
                            return 1;
                        }
                    }
                }
            } else {

                if (isDesc){
                    return -(aKeyValue - bKeyValue);
                } else {
                    return (aKeyValue - bKeyValue);
                }
            }       

            return 0;
        });

        this.refresh();
    }

    this.getHeaderValue = function(column){
        return tableHeaders[column];
    }

    this.selectedRowCount = function(){
        return this.selectedItems.length;
    }

    this.getColumnDataFromRow = function(column, rowIndex){
        return this.data[rowIndex][this.getHeaderValue(column)];
    }

    this.getColumnDataFromRows = function(column, rowIndexes){
        var data = [];

        for (var i in rowIndexes){
            data.push(this.getColumnDataFromRow(column, rowIndexes[i]));
        }

        return data;
    }

    this.addEventListener = function(name, func){
        this.events[name].push(func);
    }

    this.triggerEvent = function(name, event){
        for (var i in this.events[name]){
            this.events[name][i](event);
        }
    }

    this.init();
}