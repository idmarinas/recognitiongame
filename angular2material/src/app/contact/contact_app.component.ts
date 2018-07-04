import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { SharedService } from "../shared.service";
declare function master_notification_proc(text, type, header);

class contact_Class {
    email: string;
    subject: string;
    message: string;
}

@Component({
    selector: 'contact',
    templateUrl: './contact.html',
})

export class Contact_Component {
    contact_Item = new contact_Class();
    errorText_Array = [];
    loaded_DOM = false;
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService ) {
        this.http.post('/contact/init', null ).subscribe( res => {
            this.sharedService.master_Databaseinfo_Init.next( res[0] );
            this.sharedService.master_Proposal_Init.next( [ ...res[1], 3 ] );
            this.sharedService.master_Quickgame_Init.next( res[2] );
            this.webpageText_Array=res[3].slice(0,6);
            this.errorText_Array=res[3].slice(6,9);
            this.loaded_DOM = true;
            setTimeout(function(){ 
                document.getElementById('focusElement1').focus();
            }, 500);
        });        

    }
    
    submit_Form() {
        this.http.post('/contact/submitForm', this.contact_Item)
            .subscribe(res => {            
                master_notification_proc(this.webpageText_Array[5], 1,'');
            }
        );
    }
}
