import styled from "styled-components/native";
import { Platform, ImageBackground } from "react-native";
export const Container = styled.View`
  flex: 1;
  justify-content: flex-end;
  align-items: center;
  padding: 0 32px ${Platform.OS === "android" ? 40 : 40}px;
  font-size: 14px;
`;

export const ViewImageBackground = styled(ImageBackground).attrs({
  source: { uri: "../../assets/bg-sign.png" },
  resizeMode: "cover",
})`
  flex: 1;
  justify-content: flex-end;
  flex-direction: column;
  align-items: center;
`;

export const LogoHeader = styled.View`
  align-items: center;
`;

export const Title = styled.Text`
  font-size: 55px;
  color: #ffffff;
  margin-top: 20px;
  margin-bottom: 20px;
  font-family: "Rosario_400Regular";
`;

export const Description = styled.Text`
  font-size: 14px;
  color: #383838;
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: center;
  padding: 0 20px;
  font-family: "Rosario_400Regular";
`;

export const LinkForgotPassword = styled.TouchableOpacity`
  padding: 10px 10px;
  flex-direction: row;
  justify-content: flex-end;
  text-align: right;
`;

export const LinkForgotPasswordText = styled.Text`
  color: #fff;
`;
