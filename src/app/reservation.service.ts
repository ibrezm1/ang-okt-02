import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  private baseUrl = 'https://zoomcarft.000webhostapp.com/proj3/be/reservationv2.php';

  constructor(private http: HttpClient) { }

  // Get all guests
  getAllGuests(): Observable<any[]> {
    return this.http.get<any[]>(this.baseUrl);
  }

  getGuestById(guestId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}?id=${guestId}`);
  }

  // Create a new guest
  createGuest(guestData: any): Observable<any> {
    return this.http.post<any>(this.baseUrl, { ...guestData, operation: 'create' });
  }

  // Update an existing guest
  updateGuest(guestData: any): Observable<any> {
    return this.http.post<any>(this.baseUrl, { ...guestData, operation: 'update' });
  }

  // Delete a guest
  deleteGuest(guestId: number): Observable<any> {
    return this.http.post<any>(this.baseUrl, { guestId, operation: 'delete' });
  }
}
