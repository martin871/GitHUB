 $(document).ready(function(){               
     /*$('#btnSearch').on('click', function(e){
          var search = $('#search').val();
          var html = '';
          if(search != ""){
               $.ajax({
                    url: 'https://api.github.com/search/repositories?q='+search,                              
                    success: function(data){
                         $.each(data.items, function(index, item) {                                        
                              var license = item.license==null?'':item.license.name;
                              html += '<div class="row col-md-8 border-bottom mx-auto">';
                              html += '<div class="col-md-8">';
                              html += '<h5><a href="#" data-toggle="modal" onclick="comentarioRepositorio(this);" data-target="#exampleModalScrollable" data-repos="'+item.full_name+'" data-license="'+license+'"><em>'+item.full_name+'</em></a></h5>';
                              html += '<small class="d-block mb-3 text-muted">'+item.description+'</small>';
                              html += '</div>';
                              html += '<div class="col-md-4">';
                              html += '<small class="d-block mb-3 text-muted">'+(item.language==null?"":item.language)+'</small>';
                              html += '</div>';
                              html += '<hr>';
                              html += '</div>';
                         });
                         $('.search-repos').html(html);
                    }
               });
          }
     });*/
});

function comentarioRepositorio(data){
     var repos = $(data).attr('data-repos');
     var licencia = $(data).attr('data-license');
     var html = '';
     $.get('https://api.github.com/repos/'+repos+'/comments',function(data){          
          var dataOrd = sortJSON(data, 'updated_at');
          $.each(data, function(index, item){                         
               html += "<div class='row border-bottom'>";
               html += "<div class='col-md-12 text-muted'>";
               html += "<small>";                         
               html += "<span>"+item.user.login+"</span> - <span>"+item.author_association+"</span>";
               html += "</small>";
               html += "</div>";
               html += "<div class='col-md-12'>"+item.body+"</div>";
               html += "<div class='col-md-12 text-muted'>";
               html += "<small>";
               html += "<span>"+moment(item.updated_at, "YYYYMMDD").format('LL')+"</span>&nbsp;&nbsp;";
               html += "<span class='badge badge-secondary'>"+licencia+"</span>";
               html += "</small>";
               html += "</div>";
               html += "</div><br />";
          });                                   
          $('.modal-body').html(html);
     });
}

function sortJSON(data, key) {
    return data.sort(function (a, b) {
          var x = a[key],
          y = b[key];
          return ((x > y) ? -1 : ((x < y) ? 1 : 0));                  
    });
}     