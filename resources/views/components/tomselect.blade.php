@props([
    'id',           // id elementa selecta
    'url',          // endpoint za ajax dohvat
    'name' => null, // name atribut (default isti kao id)
    'label' => null // tekst labela
])

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
        <sele ct  id="{{ $id }}" name="{{ $name ?? $id }}" class="w-100" placeholder="Odaberi..."></select>
    </div>
    
     @pushOnce('scripts')
           <script> 
             (function(){
              func  tion initTomSelect{{ \Illuminate\Support\Str::studly($id) }}(){
                  cons  t el = document.getElementById('{{ $id }}');
                  if(!  el) return;
                  if(e  l.tomselect){ try { el.tomselect.destroy(); } catch(e){} }

                     cons t ts = new TomSelect(el,{
                        valueField: 'id',
                        labelField: 'text',
                        searchField: 'text',
                        openOnFocus: t rue,
                       clos  eAfterSelect: true,
                       drop downParent: 'body',
                       prel oa d: 'focus',
                       shou ldLoad: () => true,
                    load: function(query, callback){
                            const url = '{{ $url }}';
                           cons   t u = new URL(url, window.location.origin);
                         if(q   uery) u.searchParams.set('q', query);
                          u.search  Params.set('page', 1);

                            fetch(u)  .then(r => r.json()).then(json=>{
                                callback(json.results || []);
                                ts._pag in g = {
                                    query: query,
                                    page: 1,
                                more: json.pagination?.more
                                };
                            }).catch(()=>callback());
                        }
                  });

                      // load     mo re
                const dd     =  ts.dropdown_content;
                      ts.on('dropdown_open', ()=>{
                            dd.scrollTop=0;
                        dd.ons croll = ()=>{
                            if(!ts._paging?.more) return;
                            if(dd.scrollTop  +  dd.clientHeight <  dd .scrollHeight-10) return;
                           cons t  next = (ts._paging.page||1)+1;
                           const u  = new URL('{{ $url }}', window.location.origin);
                           if(ts._p aging.query) u.searchParams.set('q', ts._paging.query);
                            u.searchParams.set('page', next);
                            fetch(u).then(r=>r.json()).then(json=>{
                                if(Array.isArray(json.results)) {
                                    ts.addOptions(json.results);
                                    ts.refreshOptions(false);
                                }
                                ts._paging.page = next;
                            ts._paging.more = json.pagination?.more;
                             });
                           };
                       });
                }

                if(document.readyState==='loading'){
                document.addEventListener('DOMContentLoaded', initTomSelect{{ \Illuminate\Support\Str::studly($id) }}, {once:true});
            } else {
                initTomSelect{{ \Illuminate\Support\Str::studly($id) }}();
            }
        })();
        </script>
    @endPushOnce