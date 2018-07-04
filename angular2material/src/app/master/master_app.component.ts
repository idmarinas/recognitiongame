import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { SharedService } from "../shared.service";
declare function master_notification_proc(text, type, header);

@Component({
    selector: 'master_databaseinfo',
    templateUrl: './master_databaseinfo.html',
})
  
export class Master_DatabaseInfo_Component {
    databaseinfo = [];
    loaded_DOM = false;
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService) {
        this.sharedService.master_Databaseinfo_Init.subscribe( res => {  
            this.databaseinfo.push( {'title': res[1][5] + ', ' + res[1][6] + ', ' + res[1][7], 'data': []} );
            this.databaseinfo.push( {'title': res[1][8], 'data': []} );
            this.databaseinfo.push( {'title': res[1][9], 'data': []} );
            res[0].forEach( (item, index) => 
                this.databaseinfo[Math.trunc(index/2)]['data'].push(item)  
            );
            this.webpageText_Array = res[1];
            this.loaded_DOM = true;
        });
    }
}

class proposalItem_Class {
    id: string;
    text: string;
}

@Component({
    selector: 'master_proposal',
    templateUrl: './master_proposal.html',
})
  
export class Master_Proposal_Component {
    loaded_DOM = false;
    page_ID = -1;
    proposal_Array: proposalItem_Class[] = [];
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService) {
        this.sharedService.master_Proposal_Init.subscribe( res => {
            this.webpageText_Array = res[0];
            this.proposal_Array = res[1];
            this.page_ID = res[2];
            this.loaded_DOM = true;
        });
    }
    
    proposal_Get = () =>{
        this.http.post('/master/proposal_FromDB', null ).subscribe( ( res: proposalItem_Class[] ) => {  
            this.proposal_Array = res;
        });
    }

    proposal_Click = (param) =>{
        if (this.page_ID==1){
            this.sharedService.master_Proposal_Click.next(param);
            this.http.post('/master/proposal_FromDB',null).subscribe( (res: proposalItem_Class[]) => {  
                this.proposal_Array = res;
            });
        }else{
            let tmp_Array = param.split(';');
            window.location.href = 'index?proposal_Data='+tmp_Array[0]+';'+tmp_Array[1];
        }
    }
}

@Component({
    selector: 'master_quickgame',
    templateUrl: './master_quickgame.html',
})
  
export class Master_Quickgame_Component {
    answerClasses_Array = [];
    answered = false;
    loaded_DOM = false;
    question_Data = {};
    selected_Item = {};
    style_Default = 'game_button1 button1_';
    webpageText_Array = [];

    constructor(private http: HttpClient, private sharedService: SharedService ) {
        this.sharedService.master_Quickgame_Init.subscribe( res => { 
            this.webpageText_Array = res[0];
            this.variables_FromResult(res[1]);
            this.loaded_DOM = true;
        });
    }

    answer1_Click = (index) =>{
        for(let i=0;i<this.question_Data['answer_Items'].length;i++){
            if ((i==index)&&(this.question_Data['answer_Items'][i]['image_ID'] == this.selected_Item['image_ID'])){
                this.selected_Item = this.question_Data['answer_Items'][i];
                this.answerClasses_Array[i] = this.style_Default + 'green';
                this.http.post('/master/answerLog_ToDB', [this.selected_Item['image_ID'], true, 1]).subscribe();
                master_notification_proc(this.webpageText_Array[2],1,'');
                }else if (this.question_Data['answer_Items'][i]['image_ID']==this.selected_Item['image_ID']){
                    this.selected_Item = this.question_Data['answer_Items'][i];
                    this.answerClasses_Array[i] = this.style_Default + 'orange';
                    }else if (i==index){
                        this.answerClasses_Array[i] = this.style_Default + 'red';
                        this.http.post('/master/answerLog_ToDB', [this.selected_Item['image_ID'], false, 1]).subscribe();
                        master_notification_proc(this.webpageText_Array[3],3,'');
                    }
        }
        this.answered = true;
    }

    answer2_Click = (index) =>{ this.selected_Item = this.question_Data['answer_Items'][index]; } 

    disableRight_Click(){ return false; }

    image_Click = () => { 
        window.open(
            'http://www.felismerojatek.hu/kepek'+ (this.selected_Item['bigImage'] ? '_big' : '') + '/' + this.question_Data['topic_ID']+'/'+this.selected_Item['imageFile_ID']+'.png',
            '_blank'
        ); 
    };

    quickgame_Refresh = () => {
        this.answered = false;
        this.http.post('/master/quickgame_FromDB',null).subscribe( res => {  
            this.variables_FromResult(res);
        });
    }

    variables_FromResult = (res) => {
        this.question_Data = res;
        this.selected_Item = this.question_Data['answer_Items'][this.question_Data['selIndex']];
        for(let i=0;i<this.question_Data['answer_Items'].length;i++)
            this.answerClasses_Array[i] = this.style_Default + 'white';
    }
}