import "react-native-gesture-handler";
import React, { useEffect } from "react";
import { View, StatusBar } from "react-native";
import { NavigationContainer } from "@react-navigation/native";
import { useFonts, Rosario_400Regular } from "@expo-google-fonts/rosario";
import AppLoading from "expo-app-loading";
import Routes from "./src/routes";

const App: React.FC = () => {
  let [fontsLoaded] = useFonts({
    Rosario_400Regular,
  });

  if (!fontsLoaded) {
    return <AppLoading />;
  }

  return (
    <NavigationContainer independent>
      <StatusBar barStyle="light-content" backgroundColor="#FFFFFF" />
      <View style={{ flex: 1, backgroundColor: "#fff" }}>
        <Routes />
      </View>
    </NavigationContainer>
  );
};

export default App;
