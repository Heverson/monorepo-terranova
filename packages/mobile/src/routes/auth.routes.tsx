import React from 'react';
import {createStackNavigator} from '@react-navigation/stack';

import SignIn from '../pages/SignIn';
import SignUp from '../pages/SignUp';
import ForgotPassword from '../pages/ForgotPassword';
//import ValidTokenForgotPassword from '../pages/ValidTokenForgotPassword';
import UpdatedPassword from '../pages/UpdatedPassword';

const Auth = createStackNavigator();

const AuthRoutes: React.FC = () => {
  return (
    <Auth.Navigator
      screenOptions={{
        headerShown: false,
        cardStyle: {backgroundColor: '#FFF'},
      }}
      initialRouteName="SignIn">
      <Auth.Screen name="SignIn" component={SignIn} />
      <Auth.Screen name="SignUp" component={SignUp} />
      <Auth.Screen name="ForgotPassword" component={ForgotPassword} />
    
      <Auth.Screen name="UpdatedPassword" component={UpdatedPassword} />
    </Auth.Navigator>
  );
};

export default AuthRoutes;
