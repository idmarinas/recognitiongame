import { Injectable, Inject } from '@angular/core';
import { Subject } from 'rxjs/Subject';

@Injectable()
export class SharedService {
    public master_Databaseinfo_Init = new Subject<any>();
    public master_Proposal_Init = new Subject<any>();
    public master_Proposal_Click = new Subject<any>();
    public master_Quickgame_Init = new Subject<any>();
    
    public newgame_ImagesExploded = new Subject<any>();
    public newgame_ScrollIntoView = new Subject<any>();
    public newgame_ZoomLevel = new Subject<any>();
    public newgame_MistakeQuestion_Init = new Subject<any>();
    public newgame_MistakeQuestion_ScrollIntoView = new Subject<any>();
    public newgame_MistakeQuestion_ShowHide = new Subject<any>();
    public newgame_Statistics_Init = new Subject<any>();
    public newgame_Statistics_QuestionData = new Subject<any>();

    constructor() {
    }   
}