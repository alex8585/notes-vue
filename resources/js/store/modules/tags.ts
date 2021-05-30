import { VuexModule, Module, Mutation, Action, getModule } from 'vuex-module-decorators';
import store from '@/store';
import { Inertia } from '@inertiajs/inertia'

@Module({ store, dynamic: true, name: 'TagsModule' })
class TagsModule extends VuexModule  {
  public query:Query = {};
 
  get getQueryTags(): Query {
    return this.query
  }

  @Action sortHanle( {sort, defaultDirection }) {
  
    this.setQuery({sort, defaultDirection})
   
    Inertia.get(route(route().current()), this.getQueryTags, {
      replace: true,
      preserveState: true,
    })
    
  }

  @Mutation setQuery({sort, defaultDirection}: {sort:string, defaultDirection:string}): void {
    let url = new URL(window.location.href)
    let query: Query = {}
    url.searchParams.forEach((v, k) => (query[k] = v))
   
    let direction = defaultDirection == 'asc' ? 'desc' : 'asc'
    
    this.query = { ...query, direction, sort };
   
  }

}

export const tagsModule = getModule(TagsModule); 