import VueRouter from 'vue-router'
import ExampleComponent from './components/ExampleComponent'
import HomeComponent from './components/HomeComponent'
import TestSelect from './components/TestSelectComponent'

import A1Component from './components/A1Component'

import CreateCityComponent from './components/Admin/CreateCityComponent'
import CreateDistrictComponent from './components/Admin/CreateDistrictComponent'
import CreateCodeComponent from './components/Admin/CreateCodeComponent'
import CreateCommuneComponent from './components/Admin/CreateCommuneComponent'
import CreateHamletComponent from './components/Admin/CreateHamletComponent'

import CityCodeComponent from './components/A1/CityCodeComponent'
import AccountA2Component from './components/A1/AccountA2Component'
import ChartAll from './components/A1/ChartAllComponent'
import ChartCity from './components/A1/ChartCityComponent'
import ChartDisA1 from './components/A1/ChartDis'
import ChartComA1 from './components/A1/ChartCom'

import AccountA3Component from './components/A2/AccountA3Component'
import DistrictCodeComponent from './components/A2/DistrictCodeComponent'
import ChartA2 from './components/A2/MainChartComponent'
import ChartOfCity from './components/A2/ChartOfCityComponent'
import ChartCom from './components/A2/ChartComComponent'

import AccountB1Component from './components/A3/AccountB1Component'
import CommuneCodeComponent from './components/A3/CommuneCodeComponent'
import ChartA3 from './components/A3/MainChartComponent'
import ChartOfDis from './components/A3/ChartOfDisComponent'

import HamletCodeComponent from './components/B1/HamletCodeComponent'
import AccountB2Component from './components/B1/AccountB2Component'
import MainChartComponent from './components/B1/MainChartComponent'
import ChartOfCom from './components/B1/ChartOfComComponent'
import CitizenOfCom from './components/B1/CitizenOfCom'

import CensusComponent from './components/B2/CensusComponent'
import CitizenInfoComponent from './components/B2/CitizenInfoComponent'

const routes = [ 
    {path: '/createcity', component: CreateCityComponent, name: 'createcity'},
    {path: '/createdistrict', component: CreateDistrictComponent, name: 'createdistrict'},
    {path: '/createcommune', component: CreateCommuneComponent, name: 'createcommune'},
    {path: '/createhamlet', component: CreateHamletComponent, name: 'createhamlet'},

    {path: '/createcode', component: CreateCodeComponent, name: 'createcode'},
    {path: '/createa1', component: ExampleComponent, name: 'example'},
    {path: '/statsa1', component: A1Component, name: 'a1'},
    {path: '/', component: HomeComponent, name: 'home'},

    
    {path: '/createcodea2', component: CityCodeComponent, name: 'city'},
    {path: '/createcodea3', component: DistrictCodeComponent, name: 'disctrict', props: true},
    {path: '/createcodeb1', component: CommuneCodeComponent, name: 'commune'},
    {path: '/createcodeb2', component: HamletCodeComponent, name: 'hamlet'},

    {path: '/accountb2', component: AccountB2Component, name: 'accountb2'},
    {path: '/accountb1', component: AccountB1Component, name: 'accountb1'},
    {path: '/accounta3', component: AccountA3Component, name: 'accounta3', props: true},
    {path: '/accounta2', component: AccountA2Component, name: 'accounta2'}, 
 
    {path: '/census', component: CensusComponent, name: 'census'},
    {path: '/citizen', component: CitizenInfoComponent, name: 'citizen'},
    {path: '/chartb2', component: MainChartComponent, name: 'chartb2'},
    {path: '/chartofcom', component: ChartOfCom, name: 'chartofcom'},
    {path: '/chartofdis', component: ChartOfDis, name: 'chartofdis'},
    {path: '/chartofcity', component: ChartOfCity, name: 'chartofcity'},
    {path: '/chartcom', component: ChartCom, name: 'chartcom'},
    {path: '/chartall', component: ChartAll, name: 'chartall'},
    {path: '/charta3', component: ChartA3, name: 'charta3'},
    {path: '/charta2', component: ChartA2, name: 'charta2'},
    {path: '/testselect', component: TestSelect, name: 'testselect'},
    {path: '/chartcity', component: ChartCity, name: 'chartcity'},
    {path: '/chartdisa1', component: ChartDisA1, name: 'chartdisa1'},
    {path: '/chartcoma1', component: ChartComA1, name: 'chartcoma1'}, 

    {path: '/citizenofcom', component: CitizenOfCom, name: 'citizenofcom'},



  ]
const router = new VueRouter({   
    mode: 'hash',
    routes  
})
export default router;  