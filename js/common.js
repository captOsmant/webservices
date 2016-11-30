var A = {
    
    init: function(){
        
        A.Routers = [{
            hash: "#goods"
            ,path: "/modules/goods.php"
            ,handler: A.Goods
        }
        ,{
            hash: "#news"
            ,path: "/modules/news.php"
            ,handler: A.News
        },{
            hash: "#sign"
            ,path: "/modules/login.php"
            ,handler: A.Login
        }];
        
        
        window.onhashchange = function(){
            A.load(location.hash);
            
        }
        A.load(location.hash);
    }
    
    ,load: function(hash){
        for(var i in A.Routers){
            if(hash==A.Routers[i].hash){
                
                (function(i){
                    _.$("main").get(A.Routers[i].path,{},function(r){
                        _.$("a").removeClass("active");
                        _.$("a[href='"+hash+"']").addClass("active")
                        A.Routers[i].handler.init(r);
                    })
                })(i);
                
            }
        }
    }
    
    ,Routers:[]
    
    ,Login:{
        init: function(){
            _.$("form.signin").submit(function(e){
                e.preventDefault();
                var s  = {
                    username: _.$("#username").val
                    ,password: _.$("#password").val
                }
                
                _.postJSON("/modules/data/login.php",s,function(d){
                    location.reload();
                }, function(e){
                    _.$("#status").HTML(e)
                }, function(r){
                    console.error(r);
                })
            });
            
            _.$("#logout").click(function(){
                _.postJSON("/modules/data/logout.php",{}, function(){
                    location.reload();
                }, function(e){
                    console.error(e)
                }, function(r){
                    console.error(r)
                })
            })
        }
    }
    
    ,Goods:{
        init: function(){
            _.Templates.add("category");
            _.Templates.add("item");
            _.Templates.add("detail")
            _.$("form#search").display("none");
            
            A.Goods.showList();
            
            _.postJSON("/modules/data/categories.php",{},function(d){
                    d = JSON.parse(d);
                    console.log(d)
                  _.$("#cats").fromTemplate("category",d);
                  A.Goods.Categories.init()
                  A.Goods.Search.init()
            }, function(r){
                console.error(r);
            }, function(e){
                console.error(e);
            })
        }
        
        ,showList: function(){
            _.$("#items").display("block");
            _.$("#details>div").HTML("");
            _.$("#details").display("none");
        }
        
        ,Categories:{
            init: function(){
                A.Goods.showList();
                _.$("#cats li").click(this.onOpen);
                
            }
            
            ,onOpen: function(e){
                var id = _.$(this).data("id");
                _.E.category = id;
                _.$("form#search").display("block");
                
                _.$("#cats li").removeClass("active");
                _.$(this).addClass("active");
                
                _.postJSON("/modules/data/categoryItems.php",{id:id},function(d){
                    d = JSON.parse(d);
                    _.$("#items").fromTemplate("item", d);
                    A.Goods.List.init();
                },function(e){
                    console.error(e);
                },function(r){
                    console.error(r);
                })
            }
        }
        
        ,Search: {
            init: function(){
                _.$("#search").event("submit", this.onSearch)
                A.Goods.showList();
            
            }
            
            ,onSearch: function(e){
                e.preventDefault();
                
                var s = {
                    cat: _.E.category*1
                    ,min: _.$("#price_min").val
                    ,max: _.$("#price_max").val
                }
                
                _.postJSON("/modules/data/search.php",s,function(d){
                    d = JSON.parse(d)
                    _.$("#items").fromTemplate("item", d);
                },function(e){
                    console.error(e)
                },function(r){
                    console.error(r);
                })
            }
        }
        
        ,List:{
            init: function(nolist){
                if(!nolist) A.Goods.showList();
                _.$(".items li").click(this.onClick)
            }
            
            ,onClick: function(){
                var id= _.$(this).data("id")
                
                _.$("#items").display("none")
                _.$("#details").display("block");
                
               
                
                _.postJSON("/modules/data/item.php", {id: id}, function(d){
                    d = [JSON.parse(d)];
                    //console.log(d);
                    _.$("#details>div").fromTemplate("detail", d);
                     _.$("html")[0].scrollIntoView();
                    A.Goods.List.Similar.init(id)
                }, function(e){
                    
                }, function(r){
                    
                })
            }
            
            ,Similar: {
                init: function(id){
                    _.postJSON("/modules/data/similar.php", {id: id}, function(d){
                        console.log(d)
                        d = JSON.parse(d);
                        console.log(d)
                        _.$("#similar").fromTemplate("item", d);
                        A.Goods.List.init(true)
                        
                    }, function(e){
                        
                    }, function(r){
                        
                    })
                }
            }
        }
    }
    
    ,News:{
        init: function(){
            
            _.$("#news").display("block");
            _.$("#articleContents").display("none")
            
            _.$("#articleContents>a[href='#news']").click(function(e){
                e.preventDefault();
                A.News.init()
            })
                    
            _.Templates.add("article")
            _.Templates.add("articleContent");
            _.postJSON("/modules/data/articles.php",{},function(d){
                d = JSON.parse(d)
                _.$("#news").fromTemplate("article",d)
                
                A.News.List.init()
                
            }, function(e){
                
            }, function(r){
                
            })
        }    
        
        ,List:{
            init: function(){
                _.$("#news li").click(this.onClick)
            }
            
            ,onClick: function(){
                var id = _.$(this).data("id");
                _.postJSON("/modules/data/articleContent.php",{id:id}, function(d){
                    d = [JSON.parse(d)];
                    
                    _.$("#news").display("none");
                    _.$("#articleContents").display("block")
                    _.$("#articleContents div").fromTemplate("articleContent",d);
                    
                    
                }, function(e){
                    console.error(e)
                }, function(r){
                    console.error(r)
                })
            }
        }
    }
}

_.core(A.init)