import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { SharedService } from "../shared.service";

class radioItem_Class {
    id: number;
    text: string;
}

class tableItem_Class {
    id: string;
    text: string;
  }

@Component({
    selector: 'themestopics',
    templateUrl: './themestopics.html',
})

export class ThemesTopics_Component {
    loaded_DOM = false;
    radio_Array: radioItem_Class[] = new Array<radioItem_Class>();
    radio_SelectedID = 1052;
    tableData_Array: tableItem_Class[] = new Array<tableItem_Class>();
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService) {
        this.http.post('/themestopics/init', [this.radio_SelectedID] ).subscribe( res => {
            this.sharedService.master_Databaseinfo_Init.next( res[0] );
            this.sharedService.master_Proposal_Init.next( [ ...res[1], 4 ] );
            this.sharedService.master_Quickgame_Init.next( res[2] );
            for(let i=0;i<res[3][0].length;i++){
                var tmp_Item = new radioItem_Class;
                tmp_Item.text = res[3][0][i];
                tmp_Item.id = 1051+i;
                this.radio_Array.push(tmp_Item);
            }
            this.tableData_Array=res[3][1];
            this.webpageText_Array = res[4];
            this.loaded_DOM = true;
        });        
    }

    radio_Change(themetopic_ID) {
        if ( this.radio_SelectedID != themetopic_ID)
            this.http.post('/master/themesTopics_FromDB', [themetopic_ID, null]).subscribe( (res: tableItem_Class[]) => {      
                this.tableData_Array = res;
            });
    }

    proposal_Click = (id) =>{
        window.location.href = 'index?proposal_Data='+id;
    }
}    