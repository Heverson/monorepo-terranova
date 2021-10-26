import React, { useRef, useCallback, useEffect } from "react";
import {
  KeyboardAvoidingView,
  ScrollView,
  Platform,
  TextInput,
  Alert,
  Image,
  View,
} from "react-native";
import { useNavigation, useRoute } from "@react-navigation/native";
import * as Yup from "yup";
import { LinearGradient } from "expo-linear-gradient";

import { Form } from "@unform/mobile";
import { FormHandles } from "@unform/core";

import getValidationErrors from "../../utils/getValidationErrors";

import { useAuth } from "../../hooks/auth";

import Input from "../../components/Input";
import Button from "../../components/Button";

import {
  Container,
  Title,
  Description,
  LinkForgotPassword,
  LinkForgotPasswordText,
  LogoHeader,
  ViewImageBackground,
} from "./styles";

interface SignInFormData {
  email: string;
  password: string;
}

const SignIn: React.FC = () => {
  const formRef = useRef<FormHandles>(null);
  const passwordInputRef = useRef<TextInput>(null);
  const navigation = useNavigation();
  const route = useRoute();
  const { signIn } = useAuth();

  useEffect(() => {
    if (route.params) {
      formRef.current?.setData({
        email: route.params?.email,
      });
    }
  }, [route.params]);

  const handleSignIn = useCallback(
    async (data: SignInFormData) => {
      try {
        formRef.current?.setErrors({});
        const schema = Yup.object().shape({
          email: Yup.string()
            .email("Digite um email válido")
            .required("Email obrigatório"),
          password: Yup.string().required("Senha obrigatória"),
        });

        await schema.validate(data, {
          abortEarly: false,
        });

        await signIn({
          email: data.email,
          password: data.password,
        });
      } catch (err) {
        if (err instanceof Yup.ValidationError) {
          const errors = getValidationErrors(err);
          formRef.current?.setErrors(errors);
          return;
        }
        // disparar toast
        Alert.alert(
          "Erro na autenticação",
          "Ocorreu um erro ao fazer o login, cheque as credenciais"
        );
      }
    },
    [signIn]
  );

  return (
    <>
      <KeyboardAvoidingView
        style={{ flex: 1 }}
        behavior={Platform.OS === "ios" ? "padding" : undefined}
        enabled
      >
        <LinearGradient colors={["#6C2955", "#000000"]} style={{ flex: 1 }}>
          <ScrollView
            keyboardShouldPersistTaps="handled"
            contentContainerStyle={{ flex: 1 }}
          >
            <Container>
              <ViewImageBackground>
                <Title>Las mejores líneas asiáticas de cosméticos</Title>
                <Form onSubmit={handleSignIn} ref={formRef}>
                  <Input
                    name="email"
                    autoCorrect={false}
                    autoCapitalize="none"
                    keyboardType="email-address"
                    icon="mail"
                    placeholder="ingrese su nombre de usuario"
                    returnKeyType="next"
                    onSubmitEditing={() => {
                      passwordInputRef.current?.focus();
                    }}
                  />
                  <Input
                    ref={passwordInputRef}
                    name="password"
                    secureTextEntry
                    icon="lock"
                    placeholder="escribe tu contraseña"
                    returnKeyType="send"
                    onSubmitEditing={() => {
                      formRef.current?.submitForm();
                    }}
                  />
                  <Button
                    onPress={() => {
                      formRef.current?.submitForm();
                    }}
                  >
                    Iniciar sesión
                  </Button>
                </Form>
                {/* <LinkForgotPassword
                  onPress={() => navigation.navigate("ForgotPassword")}
                >
                  <LinkForgotPasswordText>
                    recuperar senha
                  </LinkForgotPasswordText>
                </LinkForgotPassword> */}
                <LinkForgotPassword
                  onPress={() => navigation.navigate("SignUp")}
                >
                  <LinkForgotPasswordText>
                    solicitar cadastro
                  </LinkForgotPasswordText>
                </LinkForgotPassword>
              </ViewImageBackground>
            </Container>
          </ScrollView>
        </LinearGradient>
      </KeyboardAvoidingView>
    </>
  );
};

export default SignIn;
