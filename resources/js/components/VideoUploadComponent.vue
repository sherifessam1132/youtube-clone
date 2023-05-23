<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload</div>

                <div class="card-body">
                    <div class="upload-box">
                        <p>Upload Your Files</p>
                        <div class="alert alert-danger" v-if="failed">something went be wrong,please try again</div>

                        <form action="">
                            <input type="file" name="video" id="video" ref="fileInput" class="form-control" @change="fileInputChange" v-if="!uploading" hidden/>
                            <div class="icon" @click="$refs.fileInput.click()">
                                <img :src="'/images/icons/upload.svg'" />
                            </div>
                            <p>Browse file to upload</p>
                        </form>
                        <section class="loading-area" v-if="uploading && !failed">
                            <div class="alert alert-success">Video will be founded in <a :href="'/videos/'+uid"> {{ $root.url }}/videos/{{ uid }}</a></div>
                            <li class="row" v-for="(file,index) in files">
                                <i class="fa fa-file-text"></i> 
                                <div class="content">
                                    <div class="details">
                                        <span class="name">{{file.name}}</span>
                                        <span class="percent">{{file.loading}}%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar loading" role="progressbar" :style="{width:file.loading + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <div class="loading-bar">
                                        <div class="loading" :style="{width:file.loading + '%'}">
                                            
                                        </div>
                                    </div> -->
                                </div>  
                            </li>  
                        </section>
                        <section class="uploaded-area" v-if="uploadComplete">
                            <li class="row" v-for="(file,index) in files">
                                <div class="content upload">
                                    <i class="fa fa-file-alt" aria-hidden="true"></i> 
                                    <div class="details">
                                        <span class="name">{{file.name}}</span>
                                        <span class="size">{{ file.loading }}%</span>
                                    </div>
                                </div>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </li>
                        </section>
                </div>
                    <div id="video-form" v-if="uploading && !failed">
                     
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" v-model="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea cols="10" rows="8" id="description" class="form-control" v-model="description">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="visibilty">visibilty</label>
                                <select name="visiblity" id="visibilty" class="form-control" v-model="visiblity">
                                    <option value="private">private</option>
                                    <option value="unlisted">unlisted</option>
                                    <option value="public">public</option>

                                </select>
                            </div>
                            <div class="row mt-2">
                                <button  type="submit" class="col-md-4 btn btn-secondary" @click.prevent="update">Save Changes</button>
                                <span class="col-md-4"></span>    
                                <span class="col-md-4 form-text">{{ saveStatus }}</span>
                            </div>

                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

    export default {
        data(){
            return{
                files:[],
                uploadedFiles:[],
                showProgress:false,
                uid:'',
                uploading:false,
                uploadComplete:false,
                failed:false,
                title:'untitled',
                description:null,
                visiblity:'private',
                saveStatus:null,
                fileProgress: 0
            }
        },
        methods:{
            fileInputChange(event)
            {
                this.uploading =true
                this.failed=false
                let file=event.target.files[0]  
                console.log(file);
                if(!file) return;
                const fileName=(file.name.length >= 12)?file.name.substring(0,13) + '... .' + file.name.split('.')[1]:file.name;
                // const formData=new FormData();
                // formData.append('file',file)
                this.files.push({name:fileName,loading:0})
                this.showProgress=true
               
                // document.getElementById('video').files[0]
                this.store(file).then(()=>{
                   
                    let form = new FormData();
                    form.append('video',file)
                    form.append('uid',this.uid)
                   return axios.post('/upload',form,{
                        onUploadProgress:({loaded,total})=>{
                            // const { loaded, total , lengthComputable } = progressEvent;
                            this.files[this.files.length -1].loading=Math.floor((loaded / total) *100)   
                            if(loaded == total){
                                const fileSize= (total < 1024) ? total + 'KB':(loaded / (1024 *1024)).toFixed(2) + 'MB';
                                this.uploadedFiles.push({name:fileName,fize:fileSize})
                                this.files=[];
                                this.showProgress=false
                            } 
                         
                            // if(progressEvent.event.lengthComputable){
                            //     this.fileProgress= (progressEvent.loaded / progressEvent.total) * 100
                            //     // this.updateProgress(progressEvent)
                            // }
                        
                        }
                    }).then(()=>{
                        this.uploadComplete =true
                    },()=>{
                        this.failed = true
                    },()=>{
                        this.failed =true
                    });
                })
            },
            updateProgress(e)
            {
                e.percent = (e.loaded / e.total) * 100
                this.fileProgress=e.percent 
            },
            store(file)
            {
              
              return axios.post('/videos',{
                title:this.title,
                description:this.description,
                visiblity:this.visiblity,
                extension:file.name.split('.').pop()
              }).then((res)=>{
                this.uid=res.data.data.uid;
              })
                
            },
            update()
            {
                this.saveStatus = "saving changes"
             return   axios.put('/videos/' + this.uid,{
                  title:  this.title,
                  description:  this.description,
                  visiblity:  this.visiblity
                }).then((res)=>{
                    this.saveStatus= 'changes saved. ';
                    setTimeout(()=>{
                        this.saveStatus = null
                    },3000)
                },()=>{
                    this.saveStatus = "failed to save changes."
                })
            },
           
        },
        mounted()
        {
            window.onbeforeunload = ()=>{
                if(this.uploading && !this.uploadComplete && !this.failed){
                    return 'Are You Sure You Want To Go Away?'
                }
            }
        }
     
    }
</script>
<style scoped>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
p,span{
    font-family: "poppins",sans-serif;

}
body{
    display: flex;
    padding: 10px;
    background: #1aaa4c;
}
.upload-box > p{
    text-align: center;
    font-weight: 500;
    margin-top: 10px;
}
img{
    width: 100%;
}
.icon  {
    width: 90px;
    height: 90px;
    background: green;
}
.upload-box{
    width: 100%;
    background: #fff;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 7px 7px 12px rgb(0, 0,0,0.05);
}
.upload-box form{
    height: 170px;
    display: flex;
    cursor: pointer;
    margin-top: 20px;
    margin-bottom: 10px;
    align-items: center;
    justify-content: center;
    flex-direction: column ;
    border-radius: 5px;
    border: 2px dashed #29ba2a;
}
form :where(i,p)
{
    color: 29ba2a;
}
form i{
    font-size: 50px;
}
form p{
    margin-top: 15px;
    font-size: 15px;
}
section .row{
    margin-bottom: 10px;
    background: #d0ffd3;
    list-style: none;
    padding: 10px;
    border-radius:10px ;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
section .row i{
    color: #1aaa4c;
    font-size: 30px;
}
section .details span{
    font-size: 12px;
}
.loading-area .row .content{ 
    width: 100%;
    margin-left: 15px;
}
.loading-area  .details
{
    display: flex;
    align-items: center;
    margin-bottom: 7px;
    justify-content: space-between;
}
.loading-area .content .loading-bar
{
    height: 6px;
    width: 100%;
    margin-bottom: 4px;
    background: #fff;
    border-radius: 30px;
}
.content .loading-bar .loading{
    height: 100%;
    width: 20%;
    background: #1aaa4c;
    border-radius: inherit;
}
.uploaded-area{
    max-height: 232px;
    overflow-y:scroll ;
}
.uploaded-area.onprogress{
    max-height: 150px;
}
.uploaded-area::-webkit-scrollbar{
    width: 0px;
}
.uploaded-area .row .content{
    display: flex;
    align-items: center;
}
.uploaded-area .row .details{
    display: flex;
    margin-top: 15px;
    flex-direction: column;
}
.uploaded-area .row .details .size{
    color: #404040;
    font-size: 11px;
}
.uploaded-area i.fa-check{
    font-size: 16px;
}
</style>
