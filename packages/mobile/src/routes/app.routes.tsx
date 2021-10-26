import React from 'react';
import {NavigationContainer} from '@react-navigation/native';
import {createStackNavigator} from '@react-navigation/stack'

const {Navigator, Screen}  = createStackNavigator()
import TabsRouter from './tab.routes';
import Home from '../pages/Home';
import Budget from '../pages/Budget';
import SignIn from '../pages/SignIn';
import SignUp from '../pages/SignUp';
import Category from '../pages/Category';
import Products from '../pages/Products';


const AppRoutes: React.FC = () => {
  return(
    <NavigationContainer independent={true}>
        <Navigator 
            initialRouteName="Home"
            screenOptions={{
              cardStyle: {backgroundColor: '#FFF'},
              headerShown: false,
            }}>
            <Screen name="Home" component={TabsRouter} />
            <Screen name="Budget" component={Budget} />
            <Screen name="SignIn" component={SignIn} />
            <Screen name="SignUp" component={SignUp} />
            <Screen name="Category" component={Category} />
            <Screen name="Products" component={Products} />
        </Navigator>
    </NavigationContainer>
  )
}

export default AppRoutes;  