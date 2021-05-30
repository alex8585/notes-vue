import { VuexModule, Module, Mutation, Action, getModule } from 'vuex-module-decorators';
import store from '@/store';
import { Inertia } from '@inertiajs/inertia'

@Module({ store, dynamic: true, name: 'CategoriesModule' })
class CategoriesModule extends VuexModule  {
  public query:Query = {};
 
  get getQuery(): Query {
    return this.query
  }

  @Action sortHanle({ sort, defaultDirection }) {
    this.setQuery(sort, defaultDirection)

    Inertia.get(route(route().current()), this.getQuery, {
      replace: true,
      preserveState: true,
    })
    
  }

  @Mutation setQuery(sort: string, defaultDirection: string): void {
    let url = new URL(window.location.href)
    let query: Query = {}
    url.searchParams.forEach((v, k) => (query[k] = v))

    let direction = query.direction ? query.direction : defaultDirection
    
    direction = direction == 'asc' ? 'desc' : 'asc'

    this.query = { ...query, direction, sort }
  }

}

export const categoriesModule = getModule(CategoriesModule); 