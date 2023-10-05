
document.addEventListener('alpine:init', () => {
  Alpine.store('reactive', {
    
    lowongan: '',
    search_type: '',
    lowongan_search: '',
    placeholder: '',

    paginate_past: [0,1,2,3,4],

    curr_select: 0,
    start_from: 0,
    end_to: 10,
    
    // call when page first load and call 'getSorted()' function
    filterInit(){
      this.getSorted();
    },

    //load data and check if user do searching with input search, or sorting
    result: function() {
      
      if (this.lowongan.length <= 0) return '';

      if(this.search_type != ''){
        return this.lowongan_search.slice(0, 20);
      }
      return this.lowongan.slice(this.start_from, this.end_to);
    },

    // filtering search input with javascript filter and includes
    fetchSearch(param){
      if(param.value == '') this.result();
      this.search_type = param.value;
      let search = []
      this.lowongan.filter(a => {
          if((a.name).toLowerCase().includes(param.value)){
            search.push(a);
          }
      })
      this.lowongan_search = search;
    },

    // Sort the data, newest or oldest by fetching data and put in on variable 'lowogang'
    async getSorted(param = 'terbaru'){
      await (await fetch(`/filters/${param}/`)).json().then(res => {
        this.lowongan = res;
        return res;
      }).catch(er => {
        console.log(er);
      })
    },

    // check if jobs are empty or not then load message
    isEmpty(){

      
      if(this.result() == '' && this.search_type != ''){
        this.placeholder = "Tidak Ada Hasil!";
        return true;
      }else if( this.result() == '' && this.search_type == ''){
        this.placeholder = "<img width='24' src='assets/animated/loading.svg' alt=''>";
        setTimeout(() => {
          this.placeholder += "<span class='text-red-800'>Sedang memuat lowongan!</span>";
        }, 15000)
        return true;
      } else{
        return false;
      }
    },

    // pagination var js
    paginate: function() {

      if(this.search_type != '') return;
      let len = this.lowongan.length;
      
      // check if job list length more than enough to make pagination
      if(len <= 10) return;

      let limit = len / 10;
      // limit number of pages, if list length more then 5 
      if(limit < 5){
        let newPageList = [];
        for (let i = 0; i < Math.ceil(limit); i++) {
          newPageList.push(i);
        }
        return newPageList;
      } else{
        return this.paginate_past;
      }
    }, 

    // Pagination with javascript 
    selectPage(param = 0){

      // if param is triple dot then return
      if(param == '...') return;

      // gap limit job for only 10 jobs for each page
      this.start_from = (param * 10);
      this.end_to = (param * 10) + 10;
      

      // if param equal to 0 and it was far from 4 then reset to original  
      if(param == 0 && this.paginate()[this.paginate().length - 1] > 4){
        this.paginate_past = [0,1,2,3,4]
      }

      // increase the number for each numbers in array until the job lists on the last one
      if(param == this.paginate()[4] && (this.lowongan.length - this.end_to) > 0){
        this.paginate()[1] = '...';
        this.paginate()[2]++;
        this.paginate()[3]++;
        this.paginate()[4]++;
      } 
      // check if param is 3 and last index value is more than 4
      if (param == 3 && this.paginate()[this.paginate().length - 1] > 4){
        this.paginate()[1] = 1;
      } 
      // check if click position on index number 2 and more than index 4
      if(param == this.paginate()[2] && this.paginate()[this.paginate().length - 1] > 4){
        this.paginate()[2]--;
        this.paginate()[3]--;
        this.paginate()[4]--;
      }
      this.curr_select = param;
    },

    // button next page
    nextPage(){
      if((this.lowongan.length - this.end_to) <= 0) return;
      this.selectPage(++this.curr_select);
    },
    
    // button previous page
    prevPage(){
      if(this.curr_select == 0) return;
      this.selectPage(--this.curr_select);
    },
  })
})

document.addEventListener('alpine:init', () => {
  Alpine.data('home', () => ({

    filterType: false,
    sortedBy: false,
    search:'',
  
    // elapse time for each job since it was created
    elapsedTime(param){
        return moment(param).fromNow();
    },


    dueTime(param = new Date()){
      return 'Berakhir '+moment().to(param);
    },


    // sorten the description of job lists
    sortParagraph(param){
      if(param.split('').length > 70){
        return param.substring(0,70) + '...';
      } else{
        return param;
      }
    },
    // check if param is triple dots '...' or not
    setNumPage(param){
      return (param == '...') ? param : param+1;
    },
  }));
})


document.addEventListener('alpine:init', () => {
    Alpine.data('apply', () => ({

      current_pos: 1,
      tipe_magang: '',

      fields: [],
      fields_len: 0,

      // input data leader
      cv_invalid_lead: false,
      job_lead: '',
      cv_lead: '',
      

      // date start & date end 
      start_date: '',
      end_date: '',

      email_pass: '', 
      valid_email: false,

      // sidebar
      isOpen: false,

      // back to top
      top_position: true,

      // placeholder for each cv members, max 5 and 4 for email member since leader already register
      email_invalid: [false,false,false,false,false],
      cv_invalid: [false,false,false,false,false],

      // Multi Step form functionality
      next(){
        // validate date start and end 
        if(this.start_date == '' || this.end_date == ''){
          return this.showAlert('Tanggal tidak boleh kosong!','');
        }
        // console.log(this.email_invalid, this.cv_invalid);
        // enter the second steps
        if(this.current_pos == 2){
          
          // check if leader pick intern job
          if(this.job_lead == ''){
            return this.showAlert('Pilih <em>job</em> yang akan dipilih!', this.$event);
          }
          
          // check if leader cv not empty or not pdf
          if(this.cv_lead == '' || this.cv_invalid_lead){
            return this.showAlert('CV ketua tidak sesuai, <br> Mohon coba lagi!', this.$event);
          }
          
          // check if leader intern type not empty
          if(this.tipe_magang == ''){
            return this.showAlert('Masukan Tipe Magang yang akan dijalankan!', this.$event);
          }
          
          // if 'kelompok', validate the form fields
          if(this.tipe_magang == 'kelompok'){

            // check if leader add members or not
            if(this.fields.length <= 0){
              return this.showAlert("Mohon masukan anggota magang kamu!", this.$event);
            }
            
            // check if leader fill the form input for each fields
            for (const field of this.fields) {
              if(field.name == '' || field.email == '' || field.job == '' || field.cv == ''){
                return this.showAlert("Masukan Data kelompok yang sesuai, <br> Mohon coba lagi!", this.$event);
              }
            }

            // console.log(this.cv_invalid, this.fields, this.fields.length);
            // check if leader upload valid PDF format for his members
            if(this.cv_invalid.indexOf(true) != -1){
              return this.showAlert("CV tidak sesuai, <br> Mohon coba lagi!", this.$event);
            }

            // check if leader fill valid email for his members 
            if(this.email_invalid.indexOf(true) != -1){
              return this.showAlert("Email tidak sesuai, <br> Mohon coba lagi!", this.$event);
            }
          }
          
        }

        // check if "next()" function get click for next step or submit
        if(this.current_pos < 2){
          this.current_pos++;
        } else{
           console.log('sent');
        }
      },

      // go back to previous step form
      previous() {
        this.current_pos--;
      },

      // add new form fields
      add_field(){
        if(this.fields.length >= 5){
          return;
        }
        this.fields_len += 1;
        this.fields.push({
          name: '',
          email: '',
          job: '',
          cv: '',
        });
      },

      // check user internship type 
      cek_output(){
        return (this.tipe_magang == 'kelompok') ? true : false;
      },

      // remove specific form field and
      remove(idx){
        this.email_invalid = [false,false,false,false,false];
        this.cv_invalid = [false,false,false,false,false];
        this.fields.forEach((item, i) => {
          if(i != idx){
            item.cv = '';
          }
        });
        this.fields.splice(idx, 1);

        return;
      },

      // validate every CV form fields
      validateCV(idx){
        if(this.fields[idx]?.cv == undefined) return;
        let splitted = this.fields[idx].cv.split('.');

        if(splitted[splitted.length - 1] == 'pdf' && splitted != ''){
          this.cv_invalid[idx] = false;
          return true;
        } else{
          this.cv_invalid[idx] = true;
          return false;
        }
      },

      // validate leader CV format
      leaderCV(){
        let splitted = this.cv_lead.split('.');
        if(splitted[splitted.length - 1] == 'pdf' && splitted != ''){
          this.cv_invalid_lead = false;
          return true;
        } else{
          this.cv_invalid_lead = true;
          return false;
        }
      },

      // validate if email is valid email w/ REGEX
      validateEmail(idx){
        if(this.fields[idx]?.email == undefined) return;
        let regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g
        if(regex.test(this.fields[idx].email)){
          this.email_invalid[idx] = false;
          return true;
        } else{
          this.email_invalid[idx] = true;
          return false;
        }
      },

      // Call Function When verification email successfully and show alert at home page
      verified(param, type = 'success'){
        return this.showAlert(param, '', type);
      },

      // card toast warning with prevent default
      showAlert(param = 'Terjadi Masalah. <br> Silahkan Coba Lagi!',event, icon = 'error'){
        if(event != '') event.preventDefault();

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: icon,
            title: param
          })
      },

      scrollPos(){
        this.top_position = (scrollY <= 200) ? true : false
      }
    }));
})

document.addEventListener('alpine:init', () => {
  Alpine.data('gates', () => ({

    // login & register password var
    FirstPASS:'',
    SecondPASS:'',
    warningMsg: '',

    // change password var
    old_pass:'',
    new_pass:'',
    repeat_pass:'',

    // forget password var
    new_forget_pass: '',
    repeat_new_forget_pass: '',
    verify_email_pass: '',

    valid_email_pass: false,
    delay_send: 0,
    
    // change password error
    old_pass_invalid:'',
    new_pass_invalid:'',
    repeat_pass_invalid:'',

    statusResponse: '',
    

    // toggle when user click eye icons to reveal the password
    isVisible: false,
    isVisible1: false,
    isVisible2: false,

    toggle() {
        this.isVisible = !this.isVisible;
    },

    toggle1() {
        this.isVisible1 = !this.isVisible1;
    },
    //second toggle repeat password form
    toggle2() {
        this.isVisible2 = !this.isVisible2;
    },
    // check if first password match with second repeat password
    match() {
      if(this.FirstPASS != this.SecondPASS){
        this.warningMsg = 'Password tidak sama, silahkan coba lagi!';
        this.$event.preventDefault();
      }
    },

    async changePassword(){
      this.$event.preventDefault();

      await fetch('/ganti-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': this.$event.srcElement[0].value
        },
        url: '/ganti-password',
        body: JSON.stringify({
          'password_lama': this.old_pass,
          'password_baru': this.new_pass,
          'confirm_password': this.repeat_pass,
        })
      }).then(res => {

        res.json().then(response => {

          if(response.error){
            this.old_pass_invalid = response.error['password_lama']
            this.new_pass_invalid = response.error['password_baru']
            this.repeat_pass_invalid = response.error['confirm_password']
            return;
          } 
          if(response.fail){
            this.old_pass_invalid = response.fail
            return;
          }
          
          this.old_pass_invalid = ""
          this.new_pass_invalid = ""
          this.repeat_pass_invalid =""
          
          window.location.href="/update-profile"

          const Toast = Swal.mixin({
              toast: true,
              position: 'bottom-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            
            Toast.fire({
              icon: 'success',
              title: response.success
            })

            this.old_pass = ''
            this.new_pass = ''
            this.repeat_pass = ''
            
          });
      }).catch(er => {
        console.log(er);
      })
    },

    validateUserEmail(){
      let regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g
        if(regex.test(this.verify_email_pass)){
          this.valid_email_pass = true;
          return true;
        } else{
          this.valid_email_pass = false;
          return false;
        }
    },

    forgetPassword(){
      console.log('submit');
      if(!this.valid_email_pass){
        this.$event.preventDefault();
      }
    }

  }));
})

// window.addEventListener("resize", () => {
//   console.log(window.innerHeight);
// })