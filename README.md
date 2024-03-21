# HotelApp

This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 17.3.0.

## Development server

Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The application will automatically reload if you change any of the source files.

## Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|guard|interface|enum|module`.

## Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory.

## Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

## Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via a platform of your choice. To use this command, you need to first add a package that implements end-to-end testing capabilities.

## Getting Help with Angular CLI

To get more help on the Angular CLI, you can use `ng help` or visit the [Angular CLI Overview and Command Reference](https://angular.io/cli) page.

### Building Your Angular Application

To build your Angular application with specific configurations, such as for production, you can use the following command:

```bash
npx ng build --configuration=production --base-href=/proj3/fe/
```

### Integration with Okta

For integrating authentication in your Angular application using Okta, you can refer to the following resources:

- **Newer 17 Version:**
  [Okta Forum Discussion](https://devforum.okta.com/t/does-okta-offer-support-for-integrating-authentication-in-angular-16-applications-using-standalone-components/26090/2)

- **Older 15 Version:**
  [Okta Developer Guide](https://developer.okta.com/docs/guides/sign-into-spa-redirect/angular/main/)

### Installing Okta Libraries

To install Okta libraries for Angular, you can use the following npm command:

```bash
npm install @okta/okta-angular@6.3 @okta/okta-auth-js@7.4
```