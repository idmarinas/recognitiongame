import { Component, ViewChild, ElementRef } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { SharedService } from "../shared.service";
import { TreeModule, TREE_ACTIONS, KEYS, IActionMapping, ITreeOptions, TreeModel, TreeComponent, TreeNode } from 'angular-tree-component';

declare function master_notification_proc(text, type, header);

class idText_Class {
    id: string;
    text: string;
}

class maxnrquestion_Class {
    max: number;
    value: number;
}

@Component({
    selector: 'index',
    templateUrl: './index.html',
})

export class Index_Component {
    gametype_Items: idText_Class[] = new Array<idText_Class>();
    gametype_SelectedID = "0";
    enablehungarian_Checked = false;
    loaded_DOM = false;
    maxnrquestion_Item = new maxnrquestion_Class();
    proposal_Data = "";
    selectedDTT_Type = [1050, 0];
    treeModule_Nodes =  [];
    treeModule_Options: ITreeOptions = {
        actionMapping: {
          mouse: {
            dblClick: (tree, node, $event) => {
              if (node.hasChildren) TREE_ACTIONS.TOGGLE_EXPANDED(tree, node, $event);
            }
          },
          keys: {
            [KEYS.ENTER]: (tree, node, $event) => {
              node.expandAll();
            }
          }
        },
        animateExpand: false
    };
    treeModule_Update2ND = false; 
    webpageText_Array = [];
    @ViewChild('treeComponent') treeComponent: TreeComponent;

    constructor(private http: HttpClient, private sharedService: SharedService, private eltRef:ElementRef)  {
        this.http.post('/index/init', null).subscribe( res => {
            this.sharedService.master_Databaseinfo_Init.next( res[0] );
            this.sharedService.master_Proposal_Init.next( [ ...res[1], 1 ] );
            this.sharedService.master_Quickgame_Init.next( res[2] );
            for(let i=0;i<6;i++){
                var tmp_item = new idText_Class;
                tmp_item.text = res[3][i];
                tmp_item.id = (i).toString();
                this.gametype_Items.push(tmp_item);
            }
            this.webpageText_Array=res[3].slice(6, 16);
            this.enablehungarian_Checked = res[4]=='hu';
            this.maxnrquestion_Item['value'] = 20;
            this.proposal_Data = this.eltRef.nativeElement.getAttribute('proposal_Data');
            if (this.proposal_Data != ""){
                let tmp_Array = this.proposal_Data.split(';');
                this.selectedDTT_Type =  [Number.parseInt(tmp_Array[0]), Number.parseInt(tmp_Array[1])];
            }else
                this.selectedDTT_Type =  [1050, 0];
            let tmp_Array = this.treeModule_Build(res[5], 0);
            tmp_Array.unshift({
                    id: '1050;0',
                    text: this.webpageText_Array[4]
            })
            this.treeModule_Nodes = tmp_Array;
            this.loaded_DOM = true;
        });
        this.sharedService.master_Proposal_Click.subscribe( data => {
            this.proposal_Data = data;
            if (this.gametype_SelectedID > "3")
                this.gametype_Change("0");
            else
                this.treeModule_UpdateData(null, null);
        });
    }

    gametype_Change = (index) => {
        let change_Array= ["4", "5"];
        if ( (this.gametype_SelectedID != index) &&
            (
                change_Array.includes(this.gametype_SelectedID) ||
                change_Array.includes(index)
            )
        ){
            this.gametype_SelectedID = index;
            if (index != "5")
                this.themesTopicsOfTheme_Get();
            else{
                this.maxnrquestion_Item.max = 20;
                this.maxnrquestion_Item.value = this.maxnrquestion_Item.max;
                this.selectedDTT_Type = [1052, 1];
                this.treeModule_Nodes = [];
            }
        }
    }

    imageCount_FromDB = () => {
        this.http.post('/index/imageCount_FromDB', [
            this.enablehungarian_Checked,
            this.selectedDTT_Type,
            this.gametype_SelectedID == '4'
        ]).subscribe( (res:number) => {
            this.maxnrquestion_Item.max = res> 20 ? 20 : res;
            if ( this.maxnrquestion_Item['value']>this.maxnrquestion_Item['max']) this.maxnrquestion_Item['value'] = this.maxnrquestion_Item['max'];
        });
    }

    enablehungarian_Click() {
        this.enablehungarian_Checked = !this.enablehungarian_Checked;
        this.themesTopicsOfTheme_Get();
    }

    themesTopicsOfTheme_Get(){
        this.http.post('/master/themesTopicsOfTheme', [
            1,
            0,
            this.enablehungarian_Checked,
            this.gametype_SelectedID == "4"
        ]).subscribe( res => {
            this.selectedDTT_Type = [1050, 0];
            let tmp_Array = this.treeModule_Build(res[0], 0);
            tmp_Array.unshift({
                    id: '1050;0',
                    text: this.webpageText_Array[4]
            })
            this.treeModule_Nodes = tmp_Array;
        });
    }

    startNewGame = () => {
        this.http.post('/index/startNewGame',[
            Number.parseInt(this.gametype_SelectedID),
            this.enablehungarian_Checked,
            this.selectedDTT_Type,
            this.maxnrquestion_Item.value
        ]).subscribe(res =>{
            window.location.href = res[0]+'/'+res[1];
        });
    }

    treeModule_Initialized(event){
        this.treeModule_UpdateData(null, null);
    }

    treeModule_Activate(event) {
        if (this.proposal_Data!=""){ 
            setTimeout( () => { 
                document.getElementById(this.selectedDTT_Type[0]+';'+this.selectedDTT_Type[1]).scrollIntoView({ block: 'center',  behavior: 'smooth' });
            }, 500);
            this.proposal_Data = "";
        }
        this.selectedDTT_Type = [
            Number.parseInt(event.node.id.substring(0,event.node.id.indexOf(';'))),
            Number.parseInt(event.node.id.substring(event.node.id.indexOf(';')+1))
        ];
        this.imageCount_FromDB();
    }

    treeModule_UpdateData (treeComponent: TreeComponent, event) {
        if (this.treeModule_Nodes.length>0){                    
            let tmp_Array = [];
            if (this.proposal_Data != ""){
                tmp_Array = this.proposal_Data.split(';');
                this.selectedDTT_Type = [
                    Number.parseInt(tmp_Array[0]),
                    Number.parseInt(tmp_Array[1])
                ];
            }
            const someNode = this.treeComponent.treeModel.getNodeById(this.selectedDTT_Type[0]+';'+this.selectedDTT_Type[1]); 
            if (someNode){
                if (this.treeModule_Update2ND){
                    master_notification_proc(this.webpageText_Array[9],2,'');
                    this.treeModule_Update2ND = false;
                }
                someNode.setActiveAndVisible(false);
            }else{
                if (this.treeModule_Update2ND){
                    this.selectedDTT_Type = [1050, 0];
                    const someNode = this.treeComponent.treeModel.getNodeById(this.selectedDTT_Type[0]+';'+this.selectedDTT_Type[1]); 
                    someNode.setActiveAndVisible(false);
                    this.treeModule_Update2ND = false;
                }else{
                    this.enablehungarian_Checked = true;
                    this.treeModule_Update2ND = true;
                    this.themesTopicsOfTheme_Get();
                }
            }
        }
    }

    treeModule_Build = (items, parent) => {
        let back_Array = [];
        items.forEach( item => {
            if (item.parent == parent ){
                if (Number.parseInt(item.id.substring(0,item.id.indexOf(';')))==1051)
                    back_Array.push({
                        id: item.id,
                        text: item.text,
                        children: this.treeModule_Build(items, Number.parseInt(item.id.substring(item.id.indexOf(';')+1 )))
                    });
                else
                    back_Array.push({
                        id: item.id,
                        text: item.text
                    });
            }
        });
        return back_Array;
    }
}
