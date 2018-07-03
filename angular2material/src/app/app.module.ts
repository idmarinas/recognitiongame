import { NgModule, ApplicationRef, Injectable } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatButtonModule, MatMenuModule, MatIconModule, MatProgressSpinnerModule, MatRadioModule, MatInputModule, MatSelectModule, MatAutocompleteModule, MatDialogModule, MatTableModule, MatSlideToggleModule } from '@angular/material';
import { MatSliderModule } from '@angular/material/slider';
import { BrowserModule } from '@angular/platform-browser';
import { SharedService } from "./shared.service";
import { HttpClientModule } from '@angular/common/http';
import { TreeModule } from 'angular-tree-component';
import { Contact_Component } from './contact/contact_app.component';
import { Index_Component } from './index/index_app.component';
import { Master_DatabaseInfo_Component, Master_Proposal_Component, Master_Quickgame_Component } from './master/master_app.component';
import { NewGame_Component, NewGame_Mistakequestion_Component, NewGame_Statistics_Component, RoundPipe } from './newgame/newgame_app.component';
import { PrivacyPolicy_Component } from './privacypolicy/privacypolicy_app.component';
import { ThemesTopics_Component } from './themestopics/themestopics_app.component';
import 'hammerjs/hammer';

@NgModule({
    declarations: [
        Contact_Component,
        Index_Component,
        Master_DatabaseInfo_Component, Master_Proposal_Component, Master_Quickgame_Component,
        NewGame_Component, NewGame_Mistakequestion_Component, NewGame_Statistics_Component,
        PrivacyPolicy_Component,
        ThemesTopics_Component,
        RoundPipe 
    ],
    entryComponents: [ 
        Contact_Component,
        Index_Component,
        Master_DatabaseInfo_Component, Master_Proposal_Component, Master_Quickgame_Component,
        NewGame_Component, NewGame_Mistakequestion_Component, NewGame_Statistics_Component,
        PrivacyPolicy_Component,
        ThemesTopics_Component,
    ],
    imports: [
        BrowserAnimationsModule,
        BrowserModule,
        HttpClientModule,
        MatButtonModule,
        MatMenuModule,
        MatIconModule,
        MatProgressSpinnerModule,
        MatRadioModule,
        MatInputModule,
        MatAutocompleteModule,
        MatSelectModule,
        MatDialogModule,
        MatTableModule,
        MatSlideToggleModule,
        MatSliderModule, 
        FormsModule,
        ReactiveFormsModule,
        TreeModule
    ],
    providers: [SharedService]
})
export class AppModule { 
	ngDoBootstrap(appRef: ApplicationRef) {
        if (document.querySelector('contact')) appRef.bootstrap(Contact_Component);
        if (document.querySelector('index')) appRef.bootstrap(Index_Component);
        if (document.querySelector('master_databaseinfo')) appRef.bootstrap(Master_DatabaseInfo_Component);
        if (document.querySelector('master_proposal')) appRef.bootstrap(Master_Proposal_Component);
        if (document.querySelector('master_quickgame')) appRef.bootstrap(Master_Quickgame_Component);
        if (document.querySelector('newgame')) appRef.bootstrap(NewGame_Component);
        if (document.querySelector('newgame_mistakequestion')) appRef.bootstrap(NewGame_Mistakequestion_Component);
        if (document.querySelector('newgame_statistics')) appRef.bootstrap(NewGame_Statistics_Component);
        if (document.querySelector('privacypolicy')) appRef.bootstrap(PrivacyPolicy_Component);                
        if (document.querySelector('themestopics')) appRef.bootstrap(ThemesTopics_Component);                
    }
}
