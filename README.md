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

Sure, here's your provided text in Markdown format:

```markdown

And here are the provided links:

- [Zoomcarft Project](https://zoomcarft.000webhostapp.com/proj3/fe/list)
- [Okta Admin API Security](https://dev-06315090-admin.okta.com/admin/oauth2/as/ausfcc2b4pTVK56h75d7)
- [Okta Authorization Server endpoint](https://dev-06315090.okta.com/oauth2/default/.well-known/oauth-authorization-server)
- [Okta Keysendpoint](https://dev-06315090.okta.com/oauth2/default/v1/keys)
- [Tutorial JWK and JWT](https://www.youtube.com/watch?v=jUzv7_SEPyo)
- [JWT.io](https://jwt.io/)
- [JWK](https://mkjwk.org/)

You can click on each link to visit the respective website or resource. If you have any further questions or need additional assistance, feel free to ask!

## Sample Token

eyJraWQiOiJjRnhrbFBlcGNYb1Ntb2pBVVhlMHdjRWNQSUtoV21URW52UTNFeklZcUNRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULmgxTWd2YUc2cnR2LU9uNExULWcwWm5BTHJ1U3JJLU1ka3VhWjBjUnlNZnciLCJpc3MiOiJodHRwczovL2Rldi0wNjMxNTA5MC5va3RhLmNvbS9vYXV0aDIvZGVmYXVsdCIsImF1ZCI6ImFwaTovL2RlZmF1bHQiLCJpYXQiOjE3MTEwNDIzMjksImV4cCI6MTcxMTA0NTkyOSwiY2lkIjoiMG9hZnd3MjVjOHFOVmUwOFE1ZDciLCJ1aWQiOiIwMHVmY2MyYjh5MkFpRk4xVTVkNyIsInNjcCI6WyJlbWFpbCIsInByb2ZpbGUiLCJvcGVuaWQiXSwiYXV0aF90aW1lIjoxNzExMDQyMjMyLCJzdWIiOiJib2phZmk1OTczQGVidXRob3IuY29tIn0.dJ9GNk6LipATd2Ky2I3ELr7o8yYBo2b8c67h-8ary7Jm4x8zw8MCiHBfHlvxAWkOISpE4ymEgIbFnl2dvzGHdEnMx-J183CVLDHTLNi2LVAybhFD0L53DXSx9vB5P1-nkOI4xzwBICfLFH_m1KTgcYxFxmr6AsguRSBq8dDwZPW-aBHxdwf56xVGjB-Wu1BevDYZ7GhD7GkzlEBdJy2U3wFfQdYnUHsaP1Xni4ZbfPvtas2cB66fAdRrw-VJ1xm-0MvfmnzzPfcua1h0brpk23poR21XuudjlppaAzkcB6KKBy78xPmjq07iNFWr7Xj7Uy2b70DNUKdsFsTZWy84Wg
```
JWK (JSON Web Key):

```json
{
  "kty": "RSA",
  "alg": "RS256",
  "kid": "cFxklPepcXoSmojAUXe0wcEcPIKhWmTEnvQ3EzIYqCQ",
  "use": "sig",
  "e": "AQAB",
  "n": "o0YwqPNwMJUNq3rJAkg70cMOw1PqtJufHu8gtc1OwZEcfL8m1Ibs06Iz6PUwn3vk0WIwqWWdJGeJEzQpH2Q1uD1uNfKm32sQbq036vB5iqIheYVG0h70pf_VOgoiT6kJN8ObF70APGvD2u5LuszC8mEk2ReO5gy_lYs3L2cBEgkSEeVlMbAor0b2W3KjVCdgOYbotx-RLczLjL0aQubSr0wBg1vZSqFLdCEQj2BDRcf-fGkh-sJHP7ffViHlp5-27ml0YYbnm6YQlXHaQ4b4Ho6f-1otDYs5rZnTCPP8L37mnWx9B2V6cKWPcnoxO_3lpiH8k9vmICAUp8QZG_NPkQ"
}
```

This JSON object represents a RSA public key in JWK format. If you have any further questions or need additional assistance, feel free to ask!
