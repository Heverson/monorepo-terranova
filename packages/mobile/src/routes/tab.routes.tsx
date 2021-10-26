import React from 'react';
import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
import {Feather} from '@expo/vector-icons';

import Home from '../pages/Home';
import Category from '../pages/Category';

const Tab = createBottomTabNavigator();

const TabsRouter: React.FC = () => {
  return (
    <Tab.Navigator
      tabBarOptions= {{
            activeTintColor: "#e7278e",
            inactiveTintColor: " #FFFFFF",
            style: {
               
                borderTopColor: '#000000',
                backgroundColor: '#000000'
            },
      }}
    >
      <Tab.Screen
        name="Home"
        component={Home}
        options={{
          tabBarIcon: ({color, size}) => (
            <Feather name="home" color="#FFF" size={size} />
          ),
        }}
      />
      <Tab.Screen
        name="Category"
        component={Category}
        options={{
          title: 'Categoría',
          tabBarIcon: ({color, size}) => (
            <Feather name="list" color="#FFF" size={size} />
          ),
        }}
      />
      
    </Tab.Navigator>
  );
};

export default TabsRouter;
