import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { SharedService } from "../shared.service";

@Component({
    selector: 'privacypolicy',
    templateUrl: './privacypolicy.html',
})

export class PrivacyPolicy_Component {
    loaded_DOM = false;
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService) {
        this.http.post('/privacypolicy/init', null).subscribe( res => {
            this.sharedService.master_Databaseinfo_Init.next( res[0] );
            this.sharedService.master_Proposal_Init.next( [ ...res[1], 2 ] );
            this.sharedService.master_Quickgame_Init.next( res[2] );
            this.webpageText_Array = res[3];
            this.loaded_DOM = true;
        });
    }
}