import { Component, ElementRef, Pipe, ViewChild, AfterViewInit } from '@angular/core';
import { SharedService } from "../shared.service";
import { HttpClient,HttpHeaders } from '@angular/common/http';
declare function master_notification_proc(notification_text_string, notification_type_int, header_string);

class imageExplodedItem_Class {
    image_ID: number;
    exploded: boolean;
}

@Component({
    selector: 'newgame',
    templateUrl: './newgame.html'
})

export class NewGame_Component{
    @ViewChild('answer_Image') answer_Image :ElementRef;
    @ViewChild('scrollIntoView1') scrollIntoView1 :ElementRef;
    @ViewChild('scrollIntoView2') scrollIntoView2 :ElementRef;
    answer_Image_Loaded = false;
    answer_Image_CSS = {};
    answer_Items = [];
    answer_Age = 50;
    imageGood_ID = -1;
    imageGood_Item = null;
    help_ImagesExploded: imageExplodedItem_Class[] = [];
    help_ZoomLevel = -1;
    loaded_DOM = false;
    question_innerHTML = '';
    questiontype = -1;
    question_Array = [-1, -1, -1, -1];
    sessionData_Random: number;
    topic_ImageFrom = -1;
    topic_Path: string;
    topic_Source = null;
    webpagetext_Array = [];

    constructor(private sharedService: SharedService, private http: HttpClient, private eltRef:ElementRef) {
        this.answer_Image_CSS = {'opacity': '0' };
        this.sessionData_Random = Number(eltRef.nativeElement.getAttribute('sessionData_Random'));
        this.http.post('/newgame/init', [-1, this.sessionData_Random]).subscribe( res => {
            this.sharedService.newgame_Statistics_Init.next( [ res[0].slice(0, 11), res[1][0]['gametype'] ] );
            this.sharedService.newgame_MistakeQuestion_Init.next(res[0].slice(11, 19));
            this.webpagetext_Array = res[0].slice(19, 33);
            this.variables_FromResult( res[1]);
            this.loaded_DOM = true;
        });
        this.sharedService.newgame_ImagesExploded.subscribe( res => { 
            this.answer_Items.map( (item, index) => {
                if (item['image_ID'] == res){
                    this.answer_Items[index]['disabled'] = true;
                    if (this.questiontype ==4)
                        this.answer_Items[index]['cssClass'] = 'game_button2_disable';
                    else                        
                        this.answer_Items[index]['cssClass'] = 'game_button1_disable button1_gray_disable';
                }
            });
            this.help_ImagesExploded.map(function(x){ return x.image_ID; }).indexOf(res)['exploded'] = true;
            this.http.post('newgame/help_Change', [
                this.sessionData_Random, this.help_ImagesExploded, , this.help_ZoomLevel]
            ).subscribe();
        });  
        this.sharedService.newgame_ScrollIntoView.subscribe( res => { 
            if ( res == -1 )
                this.scrollIntoView1.nativeElement.scrollIntoView({ block: 'center',  behavior: 'smooth' });
            if ( res > 0 )
                if (this.questiontype==4) {
                    var index= this.answer_Items.map(function(x){ return x['image_ID']; }).indexOf(res);
                    document.getElementById('scrollIntoView_AnswerImage' + index).scrollIntoView({ block: 'center',  behavior: 'smooth' });   
                }else
                    this.scrollIntoView2.nativeElement.scrollIntoView({ block: 'center',  behavior: 'smooth' });
        });        
        this.sharedService.newgame_ZoomLevel.subscribe( res => { 
            this.help_ZoomLevel = res;
            this.image_Style();
            this.http.post('newgame/help_Change', 
                [this.sessionData_Random, this.help_ImagesExploded, this.help_ZoomLevel]
            ).subscribe();
        });       
    }

    currentGameData_Get = (type = -1) => {
        this.http.post('/newgame/currentGame_Data', [type, this.sessionData_Random]).subscribe(res => {
            this.variables_FromResult(res);
        });
    }

    variables_FromResult = (res) => {
        this.questiontype = res[1]['questiontype'];
        this.help_ImagesExploded = res[1]['help_ImagesExploded'];
        this.help_ZoomLevel = res[1]['help_ZoomLevel'];
        this.imageGood_ID = res[1]['imageGood_ID'];
        this.question_Array = res[2];
        if (this.questiontype != 5)
            this.imageGood_Item =  res[1]['images'].find( item => item.image_ID == this.imageGood_ID);
        else
            this.imageGood_Item = res[1]['images'][0];
        this.question_innerHTML = res[1]['topic_Question'];
        this.sharedService.newgame_Statistics_QuestionData.next([this.question_Array, this.questiontype]);
        this.topic_ImageFrom = res[1]['topic_ImageFrom'];
        this.topic_Path = '';
        res[1]['topic_Path'].map( (item, i) => {
            if (i < res[1]['topic_Path'].length-1)
                this.topic_Path += item['text'] + ( i == res[1]['topic_Path'].length-2 ? "" : " &bull; ");
        });
        this.topic_Source = res[1]['topic_Source'];
        let border_Index = null;
        this.answer_Items = res[1]['images'];
        this.help_ImagesExploded.map( item =>{
            if (item['exploded']){
                let index_TMP = this.answer_Items.findIndex( item2 => item2['image_ID'] == item['image_ID']);
                if (index_TMP>-1)
                    if (this.question_Array[1]>-1){
                        this.answer_Items[index_TMP]['disabled'] = false;
                        this.answer_Items[index_TMP]['cssClass'] = 'game_button'+(this.questiontype == 4 ? '2' : '1')+(this.questiontype != 4 ? ' button1_white' : '');
                    }else{
                        this.answer_Items[index_TMP]['disabled'] = true;
                        if (this.questiontype == 4)
                            this.answer_Items[index_TMP]['cssClass'] = 'game_button2_disable';
                        else
                            this.answer_Items[index_TMP]['cssClass'] = 'game_button1_disable button1_gray_disable';
                    }
            }
        });
        if (this.questiontype==5){
            if ((this.question_Array[1]>-1))
                if (this.imageGood_Item['age']== this.question_Array[1])
                    master_notification_proc(this.webpagetext_Array[3],1,'');
                else
                    master_notification_proc(this.webpagetext_Array[4],3,'');
        }else{
            if (this.question_Array[1]>-1){
                let result_Type;
                this.answer_Items.map( (item, index) =>{
                    if ((item['image_ID'] == this.imageGood_Item['image_ID']) && (this.imageGood_Item['image_ID'] == this.question_Array[1])){
                        result_Type = 1;
                        border_Index = index;
                        if (this.questiontype == 4) this.answer_Items[index]['cssClass'] = 'game_button2 button2_green';
                            else this.answer_Items[index]['cssClass'] = 'game_button1 button1_green';
                        if ((this.questiontype==3)&&(index==0)){
                            border_Index = null;
                            this.answer_Items[index]['disabled'] = true;
                        }
                        if ((this.questiontype==3)&&(index==1))
                            this.answer_Items[index]['text'] = this.answer_Items[index]['textAfterAnswered'];
                        master_notification_proc(this.webpagetext_Array[3],1,'');
                    }else
                        if (item['image_ID'] == this.imageGood_Item['image_ID']){
                            result_Type = 2;
                            border_Index = index;
                            if (this.questiontype == 4) this.answer_Items[index]['cssClass'] = 'game_button2 button2_orange';
                                else this.answer_Items[index]['cssClass'] = 'game_button1 button1_orange';
                            if ((this.questiontype==3)&&(index==0)){
                                border_Index = null;
                                this.answer_Items[index]['disabled'] = true;
                                this.answer_Items[index]['cssClass'] = 'game_button1_disable button1_orange_disable';
                            }
                            if ((this.questiontype==3)&&(index==1))
                                this.answer_Items[index]['text'] = this.answer_Items[index]['textAfterAnswered'];
                        }else
                            if (item['image_ID'] == this.question_Array[1]){
                                result_Type = 3;
                                if (this.questiontype == 4) this.answer_Items[index]['cssClass'] = 'game_button2 button2_red';
                                    else this.answer_Items[index]['cssClass'] = 'game_button1 button1_red';
                                if ((this.questiontype==3)&&(index==1)){
                                    border_Index = null;
                                    this.answer_Items[index]['disabled'] = true;
                                    this.answer_Items[index]['cssClass'] = 'game_button1_disable button1_red_disable';
                                }
                                master_notification_proc(this.webpagetext_Array[4],3,'');
                            }      
                });
                if ((result_Type==1)&&(this.questiontype==3)&&(this.answer_Items[0]['disabled'])){
                    this.answer_Items[1]['disabled'] = true;
                    this.answer_Items[0]['cssClass'] = 'game_button1_disable button1_green_disable';
                    this.answer_Items[1]['cssClass'] = 'game_button1_disable button1_white_disable';
                }
            }
            if ((this.question_Array[1]>-1)&&(border_Index))
                this.answer_Items[border_Index]['cssClass'] += 
                    ' button'+(this.questiontype == 4 ? 2 : 1)+'_blueborder';
            if (this.answer_Image_Loaded){
                if((res[1]['questiontype']==1)||(res[1]['questiontype']==3)){ 
                    this.answer_Image_CSS = {'cursor': 'pointer', 'opacity': '1' };
                }
                if (res[1]['questiontype']==2){
                    if (this.answer_Image_Loaded) this.image_Style();
                }
            }
        }
    }

    image_Style = () =>{
        if (this.help_ZoomLevel>0){
            let widthClip = (this.answer_Image.nativeElement.offsetWidth * 0.125) *this.help_ZoomLevel;
            let heightClip = (this.answer_Image.nativeElement.offsetHeight * 0.125) *this.help_ZoomLevel;
            this.answer_Image_CSS = {
                'clip-path':'inset('+heightClip+'px '+widthClip+'px '+heightClip+'px '+widthClip+'px)',
                'cursor': 'no-drop',
                'opacity': '1' 
            };
        }else
            this.answer_Image_CSS = {'cursor': 'pointer', 'opacity': '1'};
    }

    answer_Image_Load = () => {
        this.answer_Image_Loaded = true;
        if((this.questiontype==1)||(this.questiontype==3)||(this.questiontype==5)){ 
            this.answer_Image_CSS = {'cursor': 'pointer', 'opacity': '1' };
        }
        if (this.questiontype==2){
            this.image_Style();
        }
    }

    answer1_Click = (image_ID) =>{
        if (this.questiontype==5)
            this.currentGameData_Get(this.answer_Age);
        else
            this.currentGameData_Get(image_ID);
    }

    answer2_Click = (index) =>{
        let item_TMP = this.answer_Items[this.answer_Items.findIndex( item => item['image_ID']==this.imageGood_Item['image_ID'])]['cssClass'];
        item_TMP = item_TMP.substring(0, item_TMP.length-18);
        this.answer_Items[this.answer_Items.findIndex( item => item['image_ID']==this.imageGood_Item['image_ID'])]['cssClass'] = item_TMP;
        this.imageGood_Item = this.answer_Items[index];
        this.answer_Items[index]['cssClass'] += ' button'+(this.questiontype == 4 ? '2' : '1')+'_blueborder';
        this.sharedService.newgame_MistakeQuestion_ShowHide.next(0);
    }   

    explode_Click = (id) =>{
        var index = this.help_ImagesExploded.map(function(x){ return x.image_ID; }).indexOf(id);
        this.help_ImagesExploded[index].exploded = true;
        this.answer_Items.map( (item, index) => {
            if (item['image_ID'] == id){
                this.answer_Items[index]['disabled'] = true;
                if (this.questiontype ==4)
                    this.answer_Items[index]['cssClass'] = 'game_button2_disable';
                else                        
                    this.answer_Items[index]['cssClass'] = 'game_button1_disable button1_gray_disable';
            }
        });
        this.http.post('newgame/help_Change', [
            this.sessionData_Random, this.help_ImagesExploded, this.help_ZoomLevel]
        ).subscribe();
        this.sharedService.newgame_ScrollIntoView.next(id);
    }
    
    nextQuestion = () => {
        if (this.question_Array[0] != this.question_Array[3]){
            this.answer_Image_Loaded = false;
            this.answer_Image_CSS = {'opacity': '0'};
            this.currentGameData_Get(-2);
            this.scrollIntoView1.nativeElement.scrollIntoView();
        }else
            window.location.href = '/';
    }

    answerImage3_Click = () => {
        window.open(
            'http://www.felismerojatek.hu/kepek' + this.imageGood_Item['bigImage']+'/' + this.imageGood_Item['topic_ID']+'/'+(this.imageGood_Item['image_ID']-this.imageGood_Item['topic_ImageFrom']+1)+'.png',
            '_blank');
    };

    imageQuestion_Click = () => {
        if (this.questiontype != 5)
            window.open(
                'http://www.felismerojatek.hu/kepek'+this.answer_Items[this.answer_Items.findIndex( x => x['image_ID']==this.imageGood_Item['image_ID'])]['bigImage']+'/'+this.imageGood_Item['topic_ID']+'/'+(this.imageGood_Item['image_ID']-this.imageGood_Item['topic_ImageFrom']+1)+'.png',
                '_blank');
        else
            window.open(
                'http://www.felismerojatek.hu/kepekage'+this.imageGood_Item['bigImage']+'/'+this.imageGood_Item['topic_ID']+'/'+this.imageGood_Item['image_ID']+'.png',
                '_blank');
    };

    age_Slide($event) {
        this.answer_Age = $event.value;
    }

    disableRightClick(){
        return false;
    }

    mistakequestion_Click = () => {
        this.sharedService.newgame_MistakeQuestion_ShowHide.next(2);
    }

    zoomlevel_Click = () =>{
        this.help_ZoomLevel--;
        this.sharedService.newgame_ScrollIntoView.next(-1);
        this.image_Style();
        this.http.post('newgame/help_Change', 
            [this.sessionData_Random, this.help_ImagesExploded, this.help_ZoomLevel]
        ).subscribe();
    }

}

@Component({
    selector: 'newgame_mistakequestion',
    templateUrl: './newgame_mistakequestion.html',
})

export class NewGame_Mistakequestion_Component {
    webpageText_Array = [];
    email_error = "";
    loaded_DOM = false;
    model = { email: '', message: '' }

    constructor(private sharedService: SharedService, private http: HttpClient, private eltRef:ElementRef) {
        this.sharedService.newgame_MistakeQuestion_Init.subscribe( res => { 
            this.webpageText_Array = res;
        });
        this.sharedService.newgame_MistakeQuestion_ShowHide.subscribe( res => { 
            // false(0), true(1), toggle(2)
            switch (res){
                case 0:
                    this.loaded_DOM = false;
                break;
                case 1:
                    this.loaded_DOM = true;
                    this.sharedService.newgame_MistakeQuestion_ScrollIntoView.next();
                break;
                case 2:
                    this.loaded_DOM = !this.loaded_DOM;
                    if (this.loaded_DOM) this.sharedService.newgame_MistakeQuestion_ScrollIntoView.next();
                break;
            }
        });
        this.sharedService.newgame_MistakeQuestion_ScrollIntoView.subscribe( res => {
            setTimeout(function(){ 
                document.getElementById('scrollIntoView3').scrollIntoView({ block: 'center',  behavior: 'smooth' });
                document.getElementById('focusElement1').focus();
            }, 500);
        });
    }

    submitForm() {
        this.http.post('/contact/submitForm', [this.model.email, 'mistakequestion',  this.model.message])
        .subscribe(res => {            
            master_notification_proc(this.webpageText_Array[3], 1,'');
            this.loaded_DOM = false;
        });
    }

    email_check() {
        if (this.model.email == "") {
            this.email_error=this.webpageText_Array[4];
        }else
            this.email_error =this.webpageText_Array[5];
        return true;
    }
}

@Pipe({ name: 'round' })
export class RoundPipe {
    transform(input: number) {
        if (Math.round(input)==input)
            return input
        else
            return input.toFixed(2);
    }
}

@Component({
    selector: 'newgame_statistics',
    templateUrl: './newgame_statistics.html',
})

export class NewGame_Statistics_Component {
    questionData_Array = [];
    gametype = -1;
    questiontype = -1;
    loaded_DOM = false;
    webpageText_Array = [];

    constructor(private sharedService: SharedService, private http: HttpClient, private eltRef:ElementRef) {
        this.sharedService.newgame_Statistics_Init.subscribe( res => { 
            this.webpageText_Array = res[0];
            this.gametype = res[1];
        });
        this.sharedService.newgame_Statistics_QuestionData.subscribe( res => {
            this.questionData_Array = res[0];
            this.questiontype = res[1];
            this.loaded_DOM = true;
        });
    }
}