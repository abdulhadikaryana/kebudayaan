    //initialize scroll to zero
    var currentpage = 0;
    var scrollRadius = 420;
    var lastPage = 1;
    var zoomIndex = 0;

            $('a.prev').click(function () {
                if (zoomIndex-1 > 0)
                {
                    if (zoomIndex-1 <= currentpage*4)
                    {
                        currentpage = currentpage - 1;
                        gotoPage(currentpage);
                    }
                     zoomIndex = zoomIndex - 1;
                     zoomImage(zoomIndex);
                     setHighlight(zoomIndex-1);
                     setImageName(zoomIndex);
                     setImageDescription(zoomIndex);
                }
            });


            $('a.next').click(function () {
              if (zoomIndex+1 <= imageTotal)
              {
                 if (zoomIndex+1 > imageCount)
                 {
                    {
                        lastPage = lastPage + 1 ;
                        getImageXML(lastPage);
                        setImageName(zoomIndex);
                        setImageDescription(zoomIndex);
                    }
                 }else{
                     if (zoomIndex+1 > currentpage*4+4)
                     {
                         zoomIndex = zoomIndex + 1;
                         zoomImage(zoomIndex);
                         setHighlight(zoomIndex-1);
                         setImageName(zoomIndex);
                         setImageDescription(zoomIndex);
                         currentpage = currentpage + 1;
                         gotoPage(currentpage);                           
                     }
                     else{
                         zoomIndex = zoomIndex + 1;
                         zoomImage(zoomIndex);
                         setHighlight(zoomIndex-1);
                         setImageName(zoomIndex);
                         setImageDescription(zoomIndex);
                     }
                 }                    
              }
            });

            
            $('a.back').click(function () {
                if (currentpage - 1 >= 0)
                {
                    currentpage = currentpage-1;
                    gotoPage(currentpage);
                    setHighlight(currentpage*4);
                    setImageName(currentpage*4+1);
                    setImageDescription(currentpage*4+1);
                    zoomImage(currentpage*4+1);
                    setZoomIndex(currentpage*4+1)
                }
            });
            
            $('a.forward').click(function () {
                if (currentpage + 1 < (imageCount/4))
                {
                    currentpage = currentpage+1;
                    gotoPage(currentpage);
                    setHighlight(currentpage*4);
                    setImageName(currentpage*4+1);
                    setImageDescription(currentpage*4+1);
                    zoomImage(currentpage*4+1);
                    setZoomIndex(currentpage*4+1)
                }
                else //two possibilities, if imageCount = total Image on database then do nothing, if imageCount < total image on database then add image 
                {
                    lastPage = lastPage + 1 ;
                    getImageXML(lastPage);
                }
            });
           
           function getImageXML(pageParam)
            {   
                $.ajax({
                   type: "POST",
                   url: ajaxImageXML,
                   data: {lastPage: pageParam, poiid: poiId},
                   success: parseXml,
                });
            }
            
            function parseXml(xml)
            {
                var total = 0;
                var nameCount = imageCount;
                var descriptionCount = imageCount;
                
                $(xml).find("data").each(function()
                {
                  total =  $(this).find("total").text();
                  if ((imageCount+4)<=total)
                  {
                      $(this).find("image").each(function(){
                         currentIndex = imageCount-1;
                         imageCount = imageCount + 1;
                         $(".wrapperCarousel ul").append("<li><img src='"+imageThumbnails+$(this).text()+"' width='75px' height='75px' onclick='highlightCarousel("+imageCount+",$(this));' /></li>");
                         imageUrl[imageCount-1] = $(this).text();
                      });

                      $(this).find("name").each(function(){
                         nameCount = nameCount + 1;
                         imageName[nameCount-1] = $(this).text();
                      });

                      $(this).find("description").each(function(){
                         descriptionCount = descriptionCount + 1;
                         imageDescription[descriptionCount-1] = $(this).text();
                      });
                      
                      currentpage = currentpage+1;
                      gotoPage(currentpage);
                  }
                zoomIndex = currentpage*4+1;
                setImageName(zoomIndex);
                setImageDescription(zoomIndex);
                setHighlight(zoomIndex-1);
                zoomImage(zoomIndex);
              });
            }

    function gotoPage(pageId)
    {
        $(".wrapperCarousel").animate({scrollLeft:pageId*scrollRadius});
    }
    
    function setHighlight(id)
    {
      $('.wrapperCarousel ul li img').css('border','1px solid #FFF');  
      $('.wrapperCarousel ul li img:eq('+id+')').css('border','3px solid #FFF');  
    }
    
    function zoomImage(id)
    {
        $('#zoom').html("<img src='"+imageFolder+imageUrl[id-1]+"' width='500px' height='375px' />");
    }
    
    function highlightImage(obj)
    {
        $('.wrapperCarousel ul li img').css('border','1px solid #FFF');
        obj.css('border','3px solid #FFF');
    }
    
    function setZoomIndex(id)
    {
        zoomIndex = id;
    }
    
    function setImageName(id)
    {
       $('#infoPanel-ImageName').text(imageName[id-1]); 
    }
    
    function setImageDescription(id)
    {
       $('#infoPanel-ImageDescription').text(imageDescription[id-1]); 
    }
    
    function highlightCarousel(id,obj)
    {
        setZoomIndex(id);
        setImageName(id);
        setImageDescription(id);
        zoomImage(id);
        highlightImage(obj);
    }
    
    function openCarouselLightbox(id)
    {
       var tempId = id - 1;
       tb_show("", "#TB_inline?height=600&width=630&inlineId=dialog&", "");
       $('.wrapperCarousel ul li img').css('border','1px solid #FFF');
       $('.wrapperCarousel ul li img:eq('+tempId+')').css('border','3px solid #FFF');  
       setZoomIndex(id);
       zoomImage(id); 
       setImageName(id);
       setImageDescription(id);
    }
