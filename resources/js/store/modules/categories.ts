import { VuexModule, Module, Mutation, Action, getModule } from 'vuex-module-decorators';
import store from '@/store';


@Module({ store, dynamic: true, name: 'CategoriesModule' })
class CategoriesModule extends VuexModule  {
  
  public categories: [] = [];
  

  get getCategories() {
    return '1233';
  }

 
}